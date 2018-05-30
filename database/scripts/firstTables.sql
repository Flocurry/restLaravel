use laravel;

drop table if exists users;
drop table if exists roles;

/* CREATE TABLE roles (
role_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
libelle VARCHAR(30) NOT NULL
) ENGINE=INNODB;

insert into roles (libelle) values ('admin'),('user');

CREATE TABLE users (
user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
role_id int(6) unsigned NOT NULL,
FOREIGN KEY (role_id) REFERENCES roles(role_id) 
) ENGINE=INNODB;

insert into users (firstname, lastname, email, role_id) values ('Florian','DARRIGAND','flodarrigand@msn.com',1); */