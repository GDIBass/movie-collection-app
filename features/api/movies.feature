Feature: Provide the ability to search for Movies from Movie DB

  In order to search for movies
  As a front end developer
  I need to be able to search for movies from the movie DB

  Scenario: Get movies with no queries
    Given I request "/api/v1/movies" using HTTP GET
    Then the response code is 400

  Scenario: Get the movies with a query
    Given I request "/api/v1/movies?q=Chicken Little" using HTTP GET
    Then the response code is 200
    And the response should contain "Chicken Little"
    And the response should be in JSON

  @fixtures
  Scenario: Get Movie already in database
    When I request "/api/v1/movies/9982" using HTTP GET
    Then the response code is 200
    And the response body contains JSON:
    """
    {
      "id":9982,
      "title":"Chicken Little",
      "release_date":"2005-11-04",
      "overview":"When the sky really is falling and sanity has flown the coop, who will rise to save the day? Together with his hysterical band of misfit friends, Chicken Little must hatch a plan to save the planet from alien invasion and prove that the world's biggest hero is a little chicken.",
      "poster_path":"\/iLMALbInUmbNn1tHmxJEWm5MyjP.jpg"
    }
    """

  Scenario: Get Movie not already in database
    When I request "/api/v1/movies/11" using HTTP GET
    Then the response code is 200
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

  Scenario: Get invalid movie
    When I request "/api/v1/movies/999999" using HTTP GET
    Then the response code is 404
    And the response body contains JSON:
    """
    {
      "detail":"MovieDB resource not found",
      "status":404,
      "type":"about:blank",
      "title":"Not Found"
    }
    """