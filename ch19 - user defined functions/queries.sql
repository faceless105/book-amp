-- User Defined Functions
DROP FUNCTION IF EXISTS rate;

CREATE FUNCTION rate (basePrice float(10,2), days INT(3))
   RETURNS FLOAT(10,2) DETERMINISTIC
   RETURN basePrice*days;

SELECT siteid, rate(basePrice, 7) AS "Weekly Rate" FROM sites;

-- Stored PROCEDURE
DELIMITER $$
CREATE PROCEDURE topEarningSite()
  SELECT siteid, SUM(charge) as "gross" FROM `reservations` GROUP BY siteid ORDER BY siteid; $$
DELIMITER ;

SELECT * FROM (CALL topEarningSite());