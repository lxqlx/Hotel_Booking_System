CREATE TABLE Customer (
email VARCHAR(256) PRIMARY KEY,
name VARCHAR(256) DEFAULT 'Customer',
password VARCHAR(256) CHECK (LENGTH(password) >5));

CREATE TABLE Hotel (
name VARCHAR(256),
address VARCHAR(256),
country VARCHAR(256),
city VARCHAR(256),
street VARCHAR(256),
rating INTEGER DEFAULT 0,
facility VARCHAR(256),
phone_no VARCHAR(20),
PRIMARY KEY (name, address));

CREATE TABLE Manager (
email VARCHAR(256),
name VARCHAR(256) DEFAULT 'Manager',
hotel_name VARCHAR(256),
hotel_address VARCHAR(256),
password VARCHAR(256) CHECK (LENGTH(password)>5),
FOREIGN KEY (hotel_name, hotel_address)
REFERENCES Hotel(name, address),
PRIMARY KEY (email));

CREATE TABLE RoomType (
hotel_name VARCHAR(256),
hotel_address VARCHAR(256),
room_type VARCHAR(10),
room_date DATE,
quantity INTEGER,
price NUMERIC CHECK (price>0),
FOREIGN KEY (hotel_name, hotel_address)
REFERENCES Hotel(name, address),
PRIMARY KEY(hotel_name, hotel_address, room_type, room_date));

CREATE TABLE Booking (
email VARCHAR(256),
booking_id CHAR(10) UNIQUE,
hotel_name VARCHAR(256),
hotel_address VARCHAR(256),
room_type VARCHAR(10),
room_date DATE,
quantity INTEGER,
total_price NUMERIC CHECK (total_price>0),
FOREIGN KEY (hotel_name, hotel_address, room_type, room_date)
REFERENCES RoomType(hotel_name, hotel_address, room_type, room_date),
FOREIGN KEY (email)
REFERENCES Customer(email),
PRIMARY KEY(booking_id, hotel_name, hotel_address, room_type, room_date)
);
