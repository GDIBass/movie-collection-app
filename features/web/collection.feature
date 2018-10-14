Feature: Provide the ability to review, search for and manage movies in my collection

  In order to be able to view and manage my movie collection
  As a web user
  I need to be able to view and search for movies in my collection, along with removing them or viewing more details

  Background:
    Given there is a user "Neo"
    And I am on "/"

  @javascript
  @fixtures
  Scenario: I can view movies in my collection
    Then I should see "Chicken Little"

  @javascript
  @fixtures
  Scenario: I can remove movies from my collection
    When I click the toggle collection button for "Chicken Little" in the "collection" section
    And I wait for "Chicken Little" in the "collection" section to finish toggling
    Then I should not see "Chicken Little"

  @javascript
  @fixtures
  Scenario: I can view movie info
    When I click the view info button for "Chicken Little"
    And I wait for the modal to load
    Then I should see "When the sky really is falling and sanity has flown the coop, who will rise to save the day"
    And I press "Close"
    And I wait for the modal to close
    Then I should not see "When the sky really is falling and sanity has flown the coop, who will rise to save the day"

  @javascript
  @fixtures
  Scenario: I can remove and add movies from my collection from the info modal
    When I click the view info button for "Chicken Little"
    And I wait for the modal to load
    Then the toggle button for "Chicken Little" in the "details" section should not be to add
    When I click the toggle collection button for "Chicken Little" in the "details" section
    And I wait for "Chicken Little" in the "details" section to finish toggling
    Then the toggle button for "Chicken Little" in the "details" section should be to add
    When I click the toggle collection button for "Chicken Little" in the "details" section
    And I wait for "Chicken Little" in the "details" section to finish toggling
    Then the toggle button for "Chicken Little" in the "details" section should not be to add

  @javascript
  @fixtures
  Scenario: I can search my collection
    Then I should see "The Lord of the Rings"
    And I fill the "collection" search with "little"
    Then I press the "collection" search button
    Then I should not see "The Lord of the Rings"
    Then I press the "collection" search clear button
    Then I should see "The Lord of the Rings"