CREATE TABLE employee (
    employee_id char(4) PRIMARY KEY, 
    full_name VARCHAR(100) NOT NULL,    
    department VARCHAR(50),             
    account VARCHAR(50) NOT NULL,       
    password VARCHAR(255) NOT NULL,     
    safety_status VARCHAR(20) DEFAULT '未回答', 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
create table form (
    employee_id char(4),
    full_name varchar(100) not null,
    department varchar(50),
    safety_status varchar(20)
);

create table register (
    employee_id char(4),
    full_name varchar(100) not null,
    account varchar(50) not null,
    password varchar(255) not null,
    department varchar(50),
    authority tinyint,
    primary key (employee_id)
);
-- LAY TTHONG TIN TU BANG EMPLOYEE => FORM
SELECT 
    e.employee_id, 
    e.full_name, 
    e.department, 
    f.safety_status
FROM employee e
LEFT JOIN form f ON e.employee_id = f.employee_id;


INSERT INTO employee(employee_id, full_name, department, account, password)
VALUES ('a015','田中　信也','管理','tanakasy.ss', 'ecc');

-- 管理
VALUES ('a011','田中　信也','管理','tanakasy.ss', 'ecc');
VALUES ('a012','田中　信也','管理','tanakasy.ss', 'ecc');
VALUES ('a013','田中　信也','管理','tanakasy.ss', 'ecc');




create table safety_options(

	id char(4),

	safety_status varchar(50) not null

)
 
 
insert into safety_options(id, safety_status)

values(1,'無事')

values(2,'ケガあり')

values(3,'出社不可')
 

