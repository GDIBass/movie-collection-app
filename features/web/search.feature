Feature: Provide the ability to search for movies add them to collection

  In order to be able to search for and manage my movie collection
  As a web user
  I need to be able to find movies from the Movie DB

  Background:
    Given there is a user "Neo"
    And I am on "/"

  @javascript
  Scenario: Clear is disabled when there is no search
    Then the "movie" search button should be disabled
    And the "movie" search clear button should be disabled

  @javascript
  Scenario: I can search movies and clear my search
    When I fill the "movie" search with "Little"
    Then the "movie" search button should not be disabled
    And I press the "movie" search button
    And I wait for the "movie" search to finish
    And I should see "Chicken Little"
    And the "movie" search button should be disabled
    And the "movie" search clear button should not be disabled
    And I press the "movie" search clear button
    And I should not see "Chicken Little"

  @javascript
  Scenario: I can search movies and add/remove them to my collection
    When I fill the "movie" search with "little"
    And I press the "movie" search button
    And I wait for the "movie" search to finish
    Then the toggle button for "Chicken Little" in the "search" section should be to add
    And I click the toggle collection button for "Chicken Little" in the "search" section
    And I wait for "Chicken Little" in the "search" section to finish toggling
    Then the toggle button for "Chicken Little" in the "search" section should not be to add
    And I click the toggle collection button for "Chicken Little" in the "search" section
    And I wait for "Chicken Little" in the "search" section to finish toggling
    Then the toggle button for "Chicken Little" in the "search" section should be to add

  @javascript
  Scenario: I can add movies and they are added to my collection, the clear filters button works
    When I fill the "movie" search with "Chicken Little"
    And I press the "movie" search button
    And I wait for the "movie" search to finish
    Then I click the toggle collection button for "Chicken Little" in the "search" section
    And I wait for "Chicken Little" in the "search" section to finish toggling
    And I press the "movie" search clear button
    Then I should see "Chicken Little"