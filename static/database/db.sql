CREATE DATABASE medico;
GRANT ALL ON medico.* TO 'root'@'localhost' IDENTIFIED by 'zappeysfc';
GRANT ALL ON medico.* TO 'root'@'127.0.0.1' IDENTIFIED by 'zappeysfc';

USE medico;
CREATE TABLE users (
	user_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(128),
    lname VARCHAR(128),
    email VARCHAR(128),
    username VARCHAR(128),
    date INTEGER(2),
    month VARCHAR(15),
    year INTEGER(4),
    password VARCHAR(128),
    INDEX(username)
) ENGINE = InnoDB;