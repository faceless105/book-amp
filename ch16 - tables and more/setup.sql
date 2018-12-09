-- Create database if it does not exist
CREATE DATABASE IF NOT EXISTS playground;

-- Create four tables
CREATE TABLE sites(
	siteid int(5) NOT NULL AUTO_INCREMENT,
    siteLabel varchar(255),
    basePrice decimal(10,2),
    siteType enum('Camper','Rustic','Cabin') NOT NULL,
    water BOOLEAN DEFAULT 0,
    30amp BOOLEAN DEFAULT 0,
    50amp BOOLEAN DEFAULT 0,
    sewer BOOLEAN DEFAULT 0,
    created datetime NOT NULL,
    PRIMARY KEY (siteid)
);

CREATE TABLE campers(
	camperid int(8) NOT NULL AUTO_INCREMENT,
    firstName varchar(255),
    lastName varchar(255),
    email varchar(255),
    favoriteColor varchar(255),
    PRIMARY KEY (camperid)
);

CREATE TABLE reservations(
	resid int(8) NOT NULL AUTO_INCREMENT,
    siteid int(5),
    camperid int(8),
    charge decimal(10,2),
    checkin datetime NOT NULL,
    -- checkout datetime NOT NULL,
    PRIMARY KEY (resid),
    FOREIGN KEY (siteid) REFERENCES sites(siteid),
    FOREIGN KEY (camperid) REFERENCES campers(camperid)
);

CREATE TABLE payments(
	paymentid int(8) NOT NULL AUTO_INCREMENT,
    resid int(5),
    paidBy int(8),
    amount int(10),
    paidAt datetime NOT NULL,
    PRIMARY KEY (paymentid),
    FOREIGN KEY (resid) REFERENCES reservations(resid),
    FOREIGN KEY (paidBy) REFERENCES campers(camperid)
);

-- Provide some alterations
ALTER TABLE campers DROP COLUMN favoriteColor;
ALTER TABLE reservations ADD checkout datetime NOT NULL;
ALTER TABLE payments MODIFY COLUMN amount decimal(10,2);

-- import older fields -- from the command line
LOAD DATA INFILE '/path/to/sites.csv' 
INTO TABLE playground 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


-- enter some seed data
-- campers
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (1, 'John', 'Smith', 'jsmith@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (2, 'Michael', 'Lee', 'mlee@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (3, 'Christopher', 'Brown', 'cbrown@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (4, 'Joshua', 'Wayne', 'jwayne@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (5, 'Matthew', 'Jimson', 'mjimson@internet.com');
-- reservations
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (1, 1, 1, 90, '2016-04-10 13:00:00', '2016-04-12 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (2, 7, 1, 225, '2016-05-22 13:00:00', '2016-05-25 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (3, 4, 1, 275, '2016-07-05 13:00:00', '2016-07-12 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (4, 19, 2, 100, '2017-06-15 13:00:00', '2017-06-20 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (5, 10, 2, 625, '2018-06-14 13:00:00', '2018-06-21 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (6, 6, 2, 275, '2019-06-15 13:00:00', '2019-06-20 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (7, 15, 3, 40, '2017-04-28 13:00:00', '2017-04-30 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (8, 11, 3, 375, '2017-09-22 13:00:00', '2017-09-25 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (9, 17, 3, 140, '2018-05-05 13:00:00', '2018-05-12 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (10, 10, 4, 375, '2016-05-10 13:00:00', '2016-05-13 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (11, 12, 4, 450, '2017-05-13 13:00:00', '2017-05-26 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (12, 14, 4, 525, '2018-05-11 13:00:00', '2018-05-14 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (13, 19, 5, 140, '2016-07-10 13:00:00', '2016-07-17 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (14, 17, 5, 260, '2018-05-12 13:00:00', '2018-05-25 15:00:00');
INSERT INTO reservations (resid, siteid, camperid, charge, checkin, checkout) VALUES (15, 20, 5, 200, '2018-09-01 13:00:00', '2018-09-11 15:00:00');
-- payments
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (1, 1, 1, 90, '2016-04-10 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (2, 2, 1, 50, '2016-04-22 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (3, 2, 1, 175, '2016-05-22 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (4, 3, 1, 50, '2016-06-05 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (5, 3, 1, 225, '2016-07-05 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (6, 4, 2, 100, '2017-06-15 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (7, 5, 2, 200, '2018-04-14 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (8, 5, 2, 200, '2018-05-14 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (9, 5, 2, 225, '2018-06-14 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (10, 6, 2, 100, '2019-06-15 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (11, 6, 2, 175, '2019-06-15 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (12, 7, 3, 40, '2017-04-28 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (13, 8, 3, 175, '2017-08-22 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (14, 8, 3, 200, '2017-09-22 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (15, 9, 3, 140, '2018-05-05 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (16, 10, 4, 50, '2016-03-10 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (17, 10, 4, 150, '2016-04-10 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (18, 10, 4, 175, '2016-05-10 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (19, 11, 4, 200, '2017-04-13 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (20, 11, 4, 250, '2017-05-13 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (21, 12, 4, 200, '2018-03-11 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (22, 12, 4, 200, '2018-04-11 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (23, 12, 4, 125, '2018-05-11 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (24, 13, 5, 140, '2016-07-10 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (25, 14, 5, 100, '2018-04-12 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (26, 14, 5, 160, '2018-05-12 13:00:00');
INSERT INTO payments (paymentid, resid, paidBy, amount, paidAt) VALUES (27, 15, 5, 200, '2018-09-01 13:00:00');

-- create a "balance" view
CREATE VIEW balance (camperid, firstName, lastName, siteid, totalOwed, totalPaid, checkin, checkout)
    AS SELECT
    	campers.camperid
    	, campers.firstName
    	, campers.lastName
    	, reservations.siteid
    	, reservations.charge AS "amountOwed"
    	, SUM(payments.amount) AS "totalPaid"
    	, (reservations.charge - SUM(payments.amount))AS "balance"
        , reservations.checkin
    	, reservations.checkout
	FROM campers
		LEFT OUTER JOIN reservations ON reservations.camperid = campers.camperid
    	LEFT OUTER JOIN payments ON payments.resid = reservations.resid
	GROUP BY campers.camperid, reservations.resid
