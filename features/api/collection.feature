Feature: Provide the ability to add or remove Movies to a user's collection

  In order to store information about my movie collection
  As a front end developer
  I need to be able to add or remove movies in a user's collection

  Background:
    Given there is a user "Neo"

  @fixtures
  Scenario: Get Full Collection
    When I request "/api/v1/collection" using HTTP GET
    # TODO: Verify a movie exists

  @fixtures
  Scenario: Get One Movie
    When I request "/api/v1/collection/9982" using HTTP GET
    # TODO: Verify response

  Scenario: Add movie to collection
    When I request "/api/v1/collection/9982" using HTTP PUT
    Then the response code is 204
    # TODO Verify movie is present

  # TODO: This scenario
  @fixtures
  Scenario: Add movie already in collection
    When I request "/api/v1/collection/9982" using HTTP PUT

  #TODO: Generate fixtures
  @fixtures
  Scenario: Remove movie from collection
    When I request "/api/v1/collection/9982" using HTTP DELETE
    Then the response code is 204
    # TODO: Verify movie is no longer present

  # TODO This scenario
  Scenario: Remove non-existent movie from collection
    When I request "/api/v1/collection/9982" using HTTP DELETE


