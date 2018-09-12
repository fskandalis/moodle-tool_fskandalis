@tool @tool_fskandalis
Feature: Creating, editing and deleting entries
  In order to manage entries
  As a teacher
  I need to be able to add, edit and delete entries

  Background:
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "users" exist:
      | username |
      | teacher1 |
      | student1 |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |

  Scenario: Add and edit an entry
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I follow "Add new record"
    And I set the following fields to these values:
      | Name        | test entry 1      |
      | Completed   | 0                 |
      | Description | Test desc         |
    And I press "Save changes"
    Then the following should exist in the "tool_fskandalis_table" table:
      | Name         | Completed | Description |
      | test entry 1 | No        | Test desc   |
    And I click on "Edit record" "link" in the "test entry 1" "table_row"
    And I set the following fields to these values:
      | Completed | 1 |
    And I press "Save changes"
    And the following should exist in the "tool_fskandalis_table" table:
      | Name         | Completed | Description |
      | test entry 1 | Yes        | Test desc   |
    And I log out

  Scenario: Delete an entry with javascript disabled
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I follow "Add new record"
    And I set the field "Name" to "test entry 1"
    And I press "Save changes"
    And I follow "Add new record"
    And I set the field "Name" to "test entry 2"
    And I press "Save changes"
    And I click on "Delete record" "link" in the "test entry 1" "table_row"
    Then I should see "test entry 2"
    And I should not see "test entry 1"
    And I log out

  @javascript
  Scenario: Delete an entry with javascript enabled
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I follow "Add new record"
    And I set the field "Name" to "test entry 1"
    And I press "Save changes"
    And I follow "Add new record"
    And I set the field "Name" to "test entry 2"
    And I press "Save changes"
    And I click on "Delete record" "link" in the "test entry 1" "table_row"
    And I press "Yes"
    Then I should see "test entry 2"
    And I should not see "test entry 1"
    And I log out
