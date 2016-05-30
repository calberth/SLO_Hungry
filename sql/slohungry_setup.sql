-- Create Database

CREATE DATABASE IF NOT EXISTS slohungry;

USE slohungry;

-- Tables For SLO HUngry
CREATE TABLE IF NOT EXISTS Restaurants (
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(256) NOT NULL,
   location VARCHAR(256),
   phone VARCHAR(25),
   rating FLOAT,
   website VARCHAR(128),
   hours VARCHAR(16),
   image VARCHAR(64),
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Food (
   id INT NOT NULL AUTO_INCREMENT,
   type VARCHAR(56) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Profiles (
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(64) NOT NULL,
   email VARCHAR(32),
   goodpass VARCHAR(256),
   PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Reviews (
   userId INT REFERENCES Profile(id),
   restId INT REFERENCES Restuarants(id),
   comment VARCHAR(564),
   price FLOAT,
   rating FLOAT
);

CREATE TABLE IF NOT EXISTS FoodRestaurants (
   foodId INT REFERENCES Food(id),
   restuarantId INT REFERENCES Restuarants(id)
);

CREATE TABLE IF NOT EXISTS Favorites (
   userId INT REFERENCES Profile(id),
   restuarantId INT REFERENCES Restuarants(id)
);
