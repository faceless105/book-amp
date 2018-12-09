-- Create database if it does not exist
CREATE DATABASE IF NOT EXISTS playground;

-- Create four tables
DROP TABLE IF EXISTS sites;
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

DROP TABLE IF EXISTS campers;
CREATE TABLE campers(
	camperid int(8) NOT NULL AUTO_INCREMENT,
    firstName varchar(255),
    lastName varchar(255),
    email varchar(255),
    PRIMARY KEY (camperid)
);

DROP TABLE IF EXISTS reservations;
CREATE TABLE reservations(
	resid int(8) NOT NULL AUTO_INCREMENT,
    siteid int(5),
    camperid int(8),
    charge decimal(10,2),
    checkin datetime NOT NULL,
    checkout datetime NOT NULL,
    balance decimal(10,2),
    PRIMARY KEY (resid),
    FOREIGN KEY (siteid) REFERENCES sites(siteid),
    FOREIGN KEY (camperid) REFERENCES campers(camperid)
);

DROP TABLE IF EXISTS payments;
CREATE TABLE payments(
	paymentid int(8) NOT NULL AUTO_INCREMENT,
    resid int(5),
    paidBy int(8),
    amount decimal(10,2),
    paidAt datetime NOT NULL,
    PRIMARY KEY (paymentid),
    FOREIGN KEY (resid) REFERENCES reservations(resid),
    FOREIGN KEY (paidBy) REFERENCES campers(camperid)
);


-- enter some data
-- sites
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (1, 1, 45, 'Camper', 1, 1, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (2, 2, 45, 'Camper', 1, 1, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (3, 3, 45, 'Camper', 1, 1, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (4, 4, 55, 'Camper', 1, 1, 1, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (5, 5, 55, 'Camper', 1, 1, 1, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (6, 6, 55, 'Camper', 1, 1, 1, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (7, 7, 75, 'Camper', 1, 1, 1, 1);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (8, 8, 75, 'Camper', 1, 1, 1, 1);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (9, 9, 75, 'Camper', 1, 1, 1, 1);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (10, 10, 125, 'Cabin', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (11, 11, 125, 'Cabin', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (12, 12, 150, 'Cabin', 1, 1, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (13, 13, 175, 'Cabin', 1, 1, 1, 1);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (14, 14, 175, 'Cabin', 1, 1, 1, 1);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (15, 15, 20, 'Rustic', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (16, 16, 20, 'Rustic', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (17, 17, 20, 'Rustic', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (18, 18, 20, 'Rustic', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (19, 19, 20, 'Rustic', 1, 0, 0, 0);
INSERT INTO sites (siteid, siteLabel, price, type, water, 30amp, 50amp, sewer) VALUES (20, 20, 20, 'Rustic', 1, 0, 0, 0);

-- campers
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (1, 'John', 'Smith', 'jsmith@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (2, 'Michael', 'Lee', 'mlee@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (3, 'Christopher', 'Brown', 'cbrown@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (4, 'Joshua', 'Wayne', 'jwayne@internet.com');
INSERT INTO campers (camperid, firstName, lastName, email) VALUES (5, 'Matthew', 'Jimson', 'mjimson@internet.com');



