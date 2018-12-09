-- a simple query
SELECT * FROM campers;
SELECT firstName, lastName from campers;

-- Distinct
SELECT DISTINCT siteid FROM reservations;

-- Left Join
SELECT
	s.siteid, s.basePrice, s.siteType, r.resid, r.siteid, r.camperid, r.charge
FROM sites s
	LEFT JOIN reservations r ON s.siteid = r.siteid

-- Inner Join
SELECT
	s.siteid, s.basePrice, s.siteType, r.resid, r.siteid, r.camperid, r.charge
FROM sites s
	INNER JOIN reservations r ON s.siteid = r.siteid

-- Right Join
SELECT
	r.resid, r.siteid, r.camperid, r.charge, s.siteid, s.basePrice, s.siteType
FROM reservations r
	RIGHT JOIN sites s ON s.siteid = r.siteid

-- Full Join
SELECT
	s.siteid, s.basePrice, s.siteType, r.resid, r.siteid, r.camperid, r.charge
FROM sites s
	FULL JOIN reservations r ON s.siteid = r.siteid

-- Where - basic
SELECT * FROM reservations r INNER JOIN sites s ON r.siteid = s.siteid WHERE checkin >= '2017-01-01';
-- WHERE - multiple grouped
SELECT * FROM reservations r INNER JOIN sites s ON r.siteid = s.siteid WHERE checkin >= '2017-01-01' AND (siteType = 'Rustic' or siteType = 'Camper');
SELECT * FROM reservations r INNER JOIN sites s ON r.siteid = s.siteid WHERE checkin >= '2017-01-01' AND siteType IN('Rustic', 'Camper');
SELECT * FROM reservations r INNER JOIN sites s ON r.siteid = s.siteid WHERE checkin BETWEEN '2017-01-01' AND '2018-12-31' AND siteType IN('Rustic', 'Cabin');
SELECT * FROM reservations r INNER JOIN sites s ON r.siteid = s.siteid WHERE checkin BETWEEN '2017-01-01' AND '2018-12-31' AND siteType NOT IN('Cabin');

-- Grouping and Aggregates
SELECT
	s.siteid, COUNT(r.resid) as "Reservations"
FROM sites s
	LEFT JOIN reservations r ON s.siteid = r.siteid
GROUP BY s.siteid;

SELECT
	s.siteid, COUNT(r.resid) as "Reservations", SUM(charge) as "Total Site Revenue", AVG(datediff(checkout, checkin)) as "Average Stay in Days"
FROM sites s
	INNER JOIN reservations r ON s.siteid = r.siteid
GROUP BY s.siteid;

-- Having
SELECT
	s.siteid, COUNT(r.resid) as "Reservations", SUM(charge) as "Total Site Revenue", AVG(datediff(checkout, checkin)) as "Average Stay in Days"
FROM sites s
	INNER JOIN reservations r ON s.siteid = r.siteid
GROUP BY s.siteid
HAVING Reservations >= 2;
-- HAVING COUNT(r.resid) >= 2;

-- Order By
SELECT * FROM campers ORDER BY lastName ASC, firstName DESC;

-- Limit
SELECT * FROM payments LIMIT 10; -- only shows the first 10 results
SELECT * FROM payments LIMIT 5, 10; -- only shows 10 results, starting from the 5th record


