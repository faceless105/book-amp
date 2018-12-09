-- Create a trigger to assure that new reservations have the correct balance applied
DELIMITER //
CREATE TRIGGER balanceCheck BEFORE INSERT ON reservations FOR EACH ROW BEGIN IF NOT NEW.balance <=> NEW.charge THEN SET NEW.balance = NEW.charge; END IF; END; //
DELIMITER;

-- moving reservations to after the triggers are made
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

-- Create a trigger to update the balance when a payment is made
DELIMETER //
CREATE TRIGGER balanceAdjust AFTER INSERT ON payments FOR EACH ROW BEGIN
    UPDATE reservations SET balance = balance - NEW.amount WHERE reservations.resid = NEW.resid;
END;//
DELIMETER;

-- moving the payment records to after the triggers are made
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
