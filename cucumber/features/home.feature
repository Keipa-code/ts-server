Feature: View home page

  Scenario: View home page content
    Given I am a guest user
    When I open "/" page
    Then I see welcome block