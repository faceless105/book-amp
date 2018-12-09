-- aliases
SELECT
	s.siteid AS "Site ID"
	, s.basePrice AS "Nightly Price"
	, s.siteType AS "Site Type"
	, r.resid
	, r.siteid
	, r.camperid
	, r.charge
FROM sites s
	LEFT JOIN reservations r ON s.siteid = r.siteid

-- Wild Cards
-- asterisks
SELECT
	s.*
	, r.resid
FROM sites s
	LEFT JOIN reservations r ON s.siteid = r.siteid

-- like
SELECT
	*
FROM campers
WHERE firstName LIKE 'J%';

-- regexp
SELECT
	*
FROM campers
WHERE firstName REGEXP '^[A-D]';

-- Selecting Defined Values
SELECT 1;
SELECT 'Hello World';
SELECT NOW();

-- Nested Queries
SELECT siteid, (SELECT COUNT(siteid) FROM reservations r WHERE r.siteid=s.siteid GROUP BY siteid) FROM sites s;
SELECT r.siteid, COUNT(r.resid) FROM (SELECT * FROM reservations) r GROUP BY r.siteid;

