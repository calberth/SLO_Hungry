-- Create Database

CREATE DATABASE IF NOT EXISTS slohungry;

USE slohungry;

-- Tables For SLO HUngry
CREATE TABLE IF NOT EXISTS Restuarants (
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(256) NOT NULL,
   hours VARCHAR(32) NOT NULL,
   website VARCHAR(128) NOT NULL,
   location VARCHAR(256) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Food (
   id INT NOT NULL AUTO_INCREMENT,
   type VARCHAR(56) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Profile (
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(128) NOT NULL,
   email VARCHAR(32) NOT NULL,
   salt VARCHAR(128) NOT NULL,
   goodpass VARCHAR(256) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Reviews (
   userId INT REFERENCES Profile(id),
   comment VARCHAR(564),
   price INT,
   rating INT
);

CREATE TABLE IF NOT EXISTS FoodRestaurants (
   foodId INT REFERENCES Food(id),
   restuarantId INT REFERENCES Restuarants(id)
);

CREATE TABLE IF NOT EXISTS Favorites (
   userId INT REFERENCES Profile(id),
   restuarantId INT REFERENCES Restuarants(id)
);
