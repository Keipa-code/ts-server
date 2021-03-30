Feature: View home page

  Scenario: View home page content
    Given I am a guest user
    When I open home page
    Then I see welcome block