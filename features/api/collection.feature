Feature: Provide the ability to add or remove Movies to a user's collection

  In order to store information about my movie collection
  As a front end developer
  I need to be able to add or remove movies in a user's collection

  Background:
    Given there is a user "Neo"

  @fixtures
  Scenario: Get Full Collection
    When I request "/api/v1/collection" using HTTP GET
    Then the response code is 200
    And the response should contain "The Lord of the Rings"
    And the response body is a JSON array of length 2

    @t
  Scenario: Get Empty Collection
    When I request "/api/v1/collection" using HTTP GET
    Then the response code is 200
    And the response body is an empty JSON array

  @fixtures
  Scenario: Get One Movie
    When I request "/api/v1/collection/9982" using HTTP GET
    Then the response code is 200
    And the response body contains JSON:
    """
    {
      "id": 9982,
      "title": "Chicken Little",
      "release_date": "2005-11-04",
      "overview": "When the sky really is falling and sanity has flown the coop, who will rise to save the day? Together with his hysterical band of misfit friends, Chicken Little must hatch a plan to save the planet from alien invasion and prove that the world's biggest hero is a little chicken.",
      "poster_path": "/iLMALbInUmbNn1tHmxJEWm5MyjP.jpg"
    }
    """

  @fixtures
  Scenario: Get Movie Not In Database
    When I request "/api/v1/collection/9983" using HTTP GET
    Then the response code is 404
    And the response body contains JSON:
    """
    {
      "detail":"Movie not found in collection.",
      "status":404,
      "type":"about:blank",
      "title":"Not Found"
    }
    """

  @fixtures
  Scenario: Get Movie Not In Collection
    When I request "/api/v1/collection/2501" using HTTP GET
    Then the response code is 404
    And the response body contains JSON:
    """
    {
      "detail":"Movie not found in collection.",
      "status":404,
      "type":"about:blank",
      "title":"Not Found"
    }
    """

  Scenario: Add movie to collection
    When I request "/api/v1/collection/9982" using HTTP PUT
    Then the response code is 201
    And I request "/api/v1/collection/9982" using HTTP GET
    Then the response code is 200
    And the response code is 200
    And the response body contains JSON:
    """
    {
      "id": 9982,
      "title": "Chicken Little",
      "release_date": "2005-11-04",
      "overview": "When the sky really is falling and sanity has flown the coop, who will rise to save the day? Together with his hysterical band of misfit friends, Chicken Little must hatch a plan to save the planet from alien invasion and prove that the world's biggest hero is a little chicken.",
      "poster_path": "/iLMALbInUmbNn1tHmxJEWm5MyjP.jpg"
    }
    """

  Scenario: Add movie to collection that is not in database
    When I request "/api/v1/collection/11" using HTTP PUT
    Then the response code is 201
    And the response body contains JSON:
    """
    {
      "message": "Movie added to collection."
    }
    """
    And I request "/api/v1/collection/11" using HTTP GET
    Then the response code is 200
    And the response code is 200
    And the response body contains JSON:
    """
    {
      "id":11,
      "title":"Star Wars",
      "release_date":"1977-05-25",
      "overview":"Princess Leia is captured and held hostage by the evil Imperial forces in their effort to take over the galactic Empire. Venturesome Luke Skywalker and dashing captain Han Solo team together with the loveable robot duo R2-D2 and C-3PO to rescue the beautiful princess and restore peace and justice in the Empire.",
      "poster_path":"\/btTdmkgIvOi0FFip1sPuZI2oQG6.jpg"
    }
    """

  @fixtures
  Scenario: Add movie already in collection
    When I request "/api/v1/collection/9982" using HTTP PUT
    Then print last response
    Then the response code is 208
    And the response body contains JSON:
    """
    {
      "message": "User already has movie."
    }
    """


  @fixtures
  Scenario: Remove movie from collection
    When I request "/api/v1/collection/9982" using HTTP DELETE
    Then the response code is 204
    And I request "/api/v1/collection/9982" using HTTP GET
    Then the response code is 404

  Scenario: Remove non-existent movie from collection
    When I request "/api/v1/collection/9982" using HTTP DELETE
    Then the response code is 404
    And the response body contains JSON:
    """
    {
      "detail":"Movie not found in collection.",
      "status":404,
      "type":"about:blank",
      "title":"Not Found"
    }
    """
    And I request "/api/v1/collections/9982" using HTTP GET
    Then the response code is 404


