Feature: CRUD a user
  I nedd to be able to register and connect.

  Scenario: Registration link is visible
    Given I am on "/"
    Then I should see "Inscription"


  Scenario: I can register
    Given I am on "/register"
    Then the response status code should be 200
    And I fill in "Login" with "test_user"
    And I fill in "Email" with "test_user"
    And I fill in "Mot de passe" with "test_user"
    And I fill in "Confirmation mot de passe" with "test_user"
    And I press "_submit"
    Then I should see "L'utilisateur a été créé avec succès"

