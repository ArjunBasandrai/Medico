CREATE DATABASE medico;
GRANT ALL ON medico.* TO 'root'@'localhost' IDENTIFIED by 'zappeysfc';
GRANT ALL ON medico.* TO 'root'@'127.0.0.1' IDENTIFIED by 'zappeysfc';

USE medico;
CREATE TABLE users (
    user_id INTEGER NOT NULL AUTO_INCREMENT,
    fname VARCHAR(128),
    lname VARCHAR(128),
    email VARCHAR(128),
    username VARCHAR(128),
    dob DATE,
    password VARCHAR(128),
    PRIMARY KEY(user_id)
) ENGINE = InnoDB;

INSERT INTO users(fname, lname, email, username, dob, password) VALUES ("Arjun","Basandrai","arjunbasandrai2004@gmail.com","Arjun122", "2004-07-01", "956152c4943615f5b45ba32bb8ba4ebf");
INSERT INTO users(fname, lname, email, username, dob, password) VALUES ("Test","Sample","text@sample.com", "Test", "2015-05-01", "6c30734811916b0f0f24a4630b08036f");

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

CREATE TABLE salt (
    salt_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    PRIMARY KEY(salt_id)
)ENGINE = InnoDB;

CREATE TABLE medicines (
    med_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    salt_id INTEGER,
    PRIMARY KEY(med_id),
    
    CONSTRAINT FOREIGN KEY (salt_id)
    REFERENCES salt (salt_id)
    ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;

CREATE TABLE pharm (
    pharm_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    address VARCHAR(255),
    coordinates POINT,
    contact VARCHAR(15),
    PRIMARY KEY(pharm_id)
)ENGINE = InnoDB;

CREATE TABLE stock (
    stock_id INTEGER NOT NULL AUTO_INCREMENT,
    stock INTEGER,
    rate FLOAT,
    med_id INTEGER,
    pharm_id INTEGER,
    PRIMARY KEY(stock_id),
    
    CONSTRAINT FOREIGN KEY (med_id)
    REFERENCES medicines (med_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
    
    CONSTRAINT FOREIGN KEY (pharm_id)
    REFERENCES pharm (pharm_id)
    ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;

CREATE TABLE orders (
    order_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER,
    stock_id INTEGER,
    stock INTEGER,
    status INTEGER,
    PRIMARY KEY(order_id),
    
    CONSTRAINT FOREIGN KEY (user_id)
    REFERENCES users (user_id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT FOREIGN KEY (stock_id)
    REFERENCES stock (stock_id)
    ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE cart (
    cart_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER,
    stock_id INTEGER,
    stock INTEGER,
    status INTEGER,
    PRIMARY KEY(cart_id),
    
    CONSTRAINT FOREIGN KEY (user_id)
    REFERENCES users (user_id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT FOREIGN KEY (stock_id)
    REFERENCES stock (stock_id)
    ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE = InnoDB;

INSERT INTO salt(name) VALUES ("Paracetamol");
INSERT INTO salt(name) VALUES ("Aspirin");
INSERT INTO salt(name) VALUES ("Ibuprofen");
INSERT INTO salt(name) VALUES ("Albuterol");
INSERT INTO salt(name) VALUES ("Metoprolol");
INSERT INTO salt(name) VALUES ("Naproxen Sodium");

INSERT INTO medicines (name, salt_id) VALUES ("Crocin", 1);
INSERT INTO medicines (name, salt_id) VALUES ("Dolo 650", 1);
INSERT INTO medicines (name, salt_id) VALUES ("Calpol 500", 1);
INSERT INTO medicines (name, salt_id) VALUES ("Disprin", 2);
INSERT INTO medicines (name, salt_id) VALUES ("Ecosprin", 2);
INSERT INTO medicines (name, salt_id) VALUES ("Delisprin", 2);
INSERT INTO medicines (name, salt_id) VALUES ("Advil", 3);
INSERT INTO medicines (name, salt_id) VALUES ("Midol",3);
INSERT INTO medicines (name, salt_id) VALUES ("Motrin", 3);
INSERT INTO medicines (name, salt_id) VALUES ("Proair RFA", 4);
INSERT INTO medicines (name, salt_id) VALUES ("Proventil HFA", 4);
INSERT INTO medicines (name, salt_id) VALUES ("Ventolin HFA", 4);
INSERT INTO medicines (name, salt_id) VALUES ("Asoprol-AS", 5);
INSERT INTO medicines (name, salt_id) VALUES ("Amtas-S", 5);
INSERT INTO medicines (name, salt_id) VALUES ("Lopressor", 5);
INSERT INTO medicines (name, salt_id) VALUES ("Stirlescent", 6);
INSERT INTO medicines (name, salt_id) VALUES ("Naprosyn", 6);
INSERT INTO medicines (name, salt_id) VALUES ("Napra-D", 6);

INSERT INTO pharm (name, address, coordinates,contact) VALUES ("Arun Pharmacy", "448 Chennai Main Road, Brammapuram, Katpadi, Vellore - 632014, Tamil Nadu" , POINT(12.9669094,79.1722112), "09944779189");
INSERT INTO pharm (name, address, coordinates,contact) VALUES ("Apollo Pharmacy", "Bus Stop, No.272,Chittoor, Katpadi, Vellore - 632007, Tamil Nadu", POINT(12.9664374,79.1368947), "04162244019");
INSERT INTO pharm (name, address, coordinates,contact) VALUES ("Om Siva Medicals", "2/2, Illango street, Tharaparvedu, Road, Katpadi, Vellore - 632007, Tamil Nadu", POINT(12.9672954,79.1373159), "09994614457");
INSERT INTO pharm (name, address, coordinates,contact) VALUES ("Shanthi Medicals", "No. 216, Vellore Road, Vellore Road, K.S.M. Store, Tarapada Vedu, Katpadi, Vellore - 632007, Tamil Nadu" , POINT(12.9674875,79.1371891), "04162246721");

INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 1, 15, 20);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 2, 25, 28.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 4, 15, 10);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 3, 15, 14.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 7, 5, 500);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 12, 3, 105);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (1, 11, 8, 121);

INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 1, 15, 15);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 2, 5, 25);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 3, 35, 12);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 4, 15, 9.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 17, 5, 50);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 15, 2, 150);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (2, 7, 5, 480);

INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 1, 10, 15);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 2, 6, 25);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 3, 35, 18);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 4, 25, 7);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 17, 5, 57.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 15, 2, 154);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 7, 5, 500);

INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 1, 15, 20);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 2, 25, 31.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 4, 15, 8.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 3, 15, 15);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 7, 5, 600);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 12, 3, 100);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (4, 11, 8, 100);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 17, 5, 59.5);
INSERT INTO stock(pharm_id, med_id, stock, rate) VALUES (3, 15, 2, 145);