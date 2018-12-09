-- Create a new user and password with local access only
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';

-- Create a new Database
CREATE DATABASE playground;

-- Create user access
GRANT ALL PRIVILEGES ON playground.* TO 'newuser'@'localhost';

-- Create a restricted account, change privileges, then remove the user
CREATE USER 'readonlyuser'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON playground.* TO 'readonlyuser'@'localhost';
REVOKE DELETE ON playground.* FROM 'readonlyuser'@'localhost';
DROP USER 'readonlyuser'@'localhost';

-- Remove the database
DROP DATABASE playground;

-- List users
select * from mysql.user;

-- Check a users privileges
SHOW GRANTS username; -- replace with an actual user name

-- List all the databases
SHOW DATABASES;

-- Create database if it does not exist
CREATE DATABASE IF NOT EXISTS playground

-- Create a user only if they do not already exist
CREATE USER IF NOT EXISTS 'readonlyuser'@'localhost' IDENTIFIED BY 'password';
