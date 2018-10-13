Feature: Provide the ability to search for movies add them to collection

  In order to be able to search for and manage my movie collection
  As a user
  I need to be able to find movies from the Movie DB

  Background:
    Given there is a user "Neo"

  @fixtures
  @javascript
  Scenario:
    When I am on "/"
