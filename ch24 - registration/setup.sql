-- Create database if it does not exist
CREATE DATABASE IF NOT EXISTS playground;

-- Create our tables
DROP TABLE IF EXISTS users;
CREATE TABLE users(
	id int(8) NOT NULL AUTO_INCREMENT,
    userEmail varchar(255),
    userPass varchar(255),
    joinDate datetime NOT NULL,
    activated BOOLEAN DEFAULT 0,
    actCode varchar(255),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
	id int(8) NOT NULL AUTO_INCREMENT,
    userid int(8) NOT NULL,
    userAgent varchar(255),
    token varchar(255),
    created datetime NOT NULL,
    lastActivity datetime NOT NULL,
    PRIMARY KEY (userid, userAgent),
    UNIQUE KEY (id)
);

-- Incase your database took the swedish default, this should help with the "Illegal mix of collations" error
-- SET collation_connection = 'utf8_general_ci';
-- ALTER DATABASE playground CHARACTER SET utf8 COLLATE utf8_general_ci;
-- ALTER TABLE users CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
-- ALTER TABLE sessions CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
