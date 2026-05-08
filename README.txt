mysql -u root -p 
GRANT RELOAD, FLUSH_PRIVILEGES ON *.* TO 'safetymanager'@'localhost';
FLUSH PRIVILEGES;

check:
SHOW GRANTS FOR 'safetymanager'@'localhost';

USE dbsaigai;


確認画面
SELECT*FROM employee;
