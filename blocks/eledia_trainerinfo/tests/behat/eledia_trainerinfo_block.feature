@block @block_eledia_trainerinfo
Feature: block_eledia_trainerinfo

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email | department | institution | city |
      | teacher1 | Teacher1 | T1 | teacher1@example.com | Department1 | Institution1 | City1 |
      | teacher2 | Teacher2 | T2 | teacher2@example.com | Department2 | Institution2 | City2 |
      | teacher3 | Teacher3 | T3 | teacher3@example.com | Department3 | Institution3 | City3 |
      | student1 | Student1 | S1 | student1@example.com | Department4 | Institution4 | City4 |

    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1 | 0 |

    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | manager |
      | teacher2 | C1 | editingteacher |
      | teacher3| C1 | teacher |
      | student1 | C1 | student |

  @javascript
  Scenario:  Add the block to the course and set role to manager
    Given I log in as "admin"
    And I set the following administration settings values:
      | block_eledia_trainerinfo_role_course | Manager |
    And I log out
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    When I add the "Referee of this Course" block

    Then I should see "Teacher1" in the "Referee of this Course" "block"
    And I should see "Department1" in the "Referee of this Course" "block"
    And I should see "Institution1" in the "Referee of this Course" "block"
    And I should see "City1" in the "Referee of this Course" "block"
    And I should not see "Teacher2" in the "Referee of this Course" "block"
    And I should not see "Department2" in the "Referee of this Course" "block"
    And I should not see "Institution2" in the "Referee of this Course" "block"
    And I should not see "City2" in the "Referee of this Course" "block"

  @javascript
  Scenario:  Add the block to the course and set role to editingteacher
  and then to non-editingteacher and then to student
    Given I log in as "admin"
    And I set the following administration settings values:
      | block_eledia_trainerinfo_role_course | Teacher |
    And I log out
    Given I log in as "teacher2"
    And I am on "Course 1" course homepage with editing mode on
    When I add the "Referee of this Course" block

    Then I should see "Teacher2" in the "Referee of this Course" "block"
    And I should see "Department2" in the "Referee of this Course" "block"
    And I should see "Institution2" in the "Referee of this Course" "block"
    And I should see "City2" in the "Referee of this Course" "block"
    And I should not see "Teacher1" in the "Referee of this Course" "block"
    And I should not see "Department1" in the "Referee of this Course" "block"
    And I should not see "Institution1" in the "Referee of this Course" "block"
    And I should not see "City1" in the "Referee of this Course" "block"
    And I log out
    And I log in as "admin"
    And I set the following administration settings values:
      | block_eledia_trainerinfo_role_course | Non-editing teacher |
    And I log out
    Given I log in as "teacher3"
    When I am on "Course 1" course homepage
    Then I should see "Teacher3" in the "Referee of this Course" "block"
    And I log out
    And I log in as "admin"
    And I set the following administration settings values:
      | block_eledia_trainerinfo_role_course | Student |
    And I log out
    Given I log in as "student1"
    When I am on "Course 1" course homepage
    Then I should see "Student1" in the "Referee of this Course" "block"
