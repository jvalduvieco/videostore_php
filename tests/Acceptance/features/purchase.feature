Feature: Rent some movies
  In order to have some good time with his family the user wants to rent some movies
  As a customer
  I am able to choose some movies and get my rental statement so I can pay and go home
  Scenario: Rent some movies
    Given I sign up as giving my name "Juan Lopez Garcia"
    And then I rent the following movies
      | type       | title                      | days |
      | children   | Daniel el travieso         | 2    |
      | regular    | La mascara                 | 1    |
      | children   | La historia interminable I | 2    |
      | newRelease | Deadpool                   | 3    |
    When I request my rental statement
    Then I shoud see the next report
"""
Rental Record for Juan Lopez Garcia
	Daniel el travieso	1.5
	La mascara	2.0
	La historia interminable I	1.5
	Deadpool	9.0
You owed 14
You earned 5 frequent renter points

"""