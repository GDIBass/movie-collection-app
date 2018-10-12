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

