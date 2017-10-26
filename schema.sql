
CREATE TABLE departments(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name varchar(20),
  description varchar(400)
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email varchar(100) not null,
  first_name varchar(20) not null,
  last_name varchar(20) not null,
  username varchar(100) unique not null, 
  password varchar(100) not null,
  registration_date timestamp default current_timestamp,
  department_id int,
  Foreign key(department_id) REFERENCES departments(id)
  on delete set null
);

CREATE TABLE courses(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name varchar(20) not null,
  description varchar(400) ,
  instructor_name varchar(30),
  credit_hours int not null,
  department_id int default null,
  Foreign key(department_id) REFERENCES departments(id)
  on delete set null
);

CREATE TABLE enrolled(
  user_id INT,
  course_id INT,
  PRIMARY key (user_id,course_id),
  Foreign key (user_id) REFERENCES users(id),
  Foreign key (course_id) REFERENCES courses(id)
);