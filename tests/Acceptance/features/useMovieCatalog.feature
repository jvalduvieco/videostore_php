Feature: Use a Video Catalog to store movies and strategy catalog to calculate frequent rental points and rental amount
  In order to have a centralized catalog of available movies
  As a VideoStore manager
  I am able to choose some movies and get rental information and frequent renter points
  Scenario: Rent some movies with my fully configurable store
    Given The following strategies to calculate frequent renter points and rental amount are present in the catalog:
      |type    |frequent_renter_points_strategy  | frequent_renter_points_strategy_parameters                                |
      |children|Fixed                            | {"fixedPoints": 1}                                                        |
      |regular |Fixed                            | {"fixedPoints": 2}                                                        |
      |new     |FixedForNDaysFixedLater          | {"fixedPoints": 1, "daysAtFixedPoints":1, "PointsWhenProportional": 2}    |
    And the following strategies to calculate rental amount:
      |type    | rental_amount_calculator_strategy  | rental_amount_calculator_strategy_parameters                                |
      |children| FixedForNDaysProportionalLater     | {"fixedPoints": 1.5, "daysAtFixedPoints":3, "PointsWhenProportional": 1.5}  |
      |regular | FixedForNDaysProportionalLater     | {"fixedPoints": 2, "daysAtFixedPoints":2, "PointsWhenProportional": 1.5 }   |
      |new     | Proportional                       | {"fixedPoints": 4}                                                          |
    And the following movies are in the videostore catalog:
      |type    |title                               |
      |children|Daniel el travieso                  |
      |regular |La mascara                          |
      |children|La historia interminable I          |
      |new     |Deadpool                            |
    When I rent the following movies
      |type    |title                               |days|
      |children|Daniel el travieso                  |2   |
      |regular |La mascara                          |1   |
      |children|La historia interminable I          |2   |
      |new     |Deadpool                            |3   |
    Then I shoud see the next report
"""
Rental Record for Juan Lopez Garcia
    Daniel el travieso  1.5
    La mascara  2.0
    La historia interminable I  1.5
    Deadpool    12.0
You owed 17
You earned 6 frequent renter points
"""