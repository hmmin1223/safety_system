DROP USER IF EXISTS safetymanager;
CREATE USER safetymanager IDENTIFIED BY 'ecc';

DROP DATABASE IF EXISTS dbsaigai;

CREATE DATABASE dbsaigai;

GRANT ALL ON dbsaigai.* TO safetymanager;

USE dbsaigai;
source table_saigai.sql;

SELECT * from employee;
select * from form; 