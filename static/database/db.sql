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

INSERT INTO users(fname, lname, email, username, password) VALUES ("Arjun","Basandrai","arjunbasandrai2004@gmail.com","Arjun122","956152c4943615f5b45ba32bb8ba4ebf");
INSERT INTO users(fname, lname, email, username, password) VALUES ("Test","Sample","text@sample.com", "Test", "6c30734811916b0f0f24a4630b08036f");

CREATE TABLE hospitals(
    h_id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    address VARCHAR(255),
    site VARCHAR(128),
    coordinates POINT NOT NULL,
    contact VARCHAR(15) NOT NULL
) ENGINE = InnoDB;

INSERT INTO hospitals(name, address,site,coordinates, contact) VALUES ("Christian Medical College and Hospital", "Christian Medical College, Ida Scudder Road, Vellore - 632004,Tamil Nadu","https://www.cmch-vellore.edu/", POINT(12.9245745,79.1352709), '+919498760000');
INSERT INTO hospitals(name, address,site,coordinates, contact) VALUES ("Naruvi Hospital", "Chennai - Bengaluru Highway, 72, Collector's Office Rd, Vellore - 632004, Tamil Nadu","https://www.naruvihospitals.com/", POINT(12.9349454,79.1391878),'04166661111');