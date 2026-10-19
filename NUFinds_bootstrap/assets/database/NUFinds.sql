CREATE DATABASE NUFinds;
USE NUFinds;

CREATE TABLE User_Credentials (
    id INT PRIMARY KEY auto_increment,
    username varchar(255) NOT NULL UNIQUE,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Staff') NOT NULL /* 'Admin' (Lost & Found Staff), 'Staff' (Utility / Guard) */
);

CREATE TABLE found_items (
    found_id INT PRIMARY KEY auto_increment,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    location_found VARCHAR(255) NOT NULL,
    date_found DATE NOT NULL,
    img_path VARCHAR(255),
    status ENUM('Unclaimed', 'Claimed', 'Disposed') NOT NULL DEFAULT 'Unclaimed'
);

CREATE TABLE lost_items (
    report_id INT PRIMARY KEY auto_increment,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    location_lost VARCHAR(255),
    date_lost DATE,
    student_id VARCHAR(12) NOT NULL,
    student_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_reported DATE NOT NULL,
    img_path VARCHAR(255),
    status ENUM('Open', 'Resolved') NOT NULL DEFAULT 'Open'
);

CREATE TABLE claim_item (
    claim_id INT PRIMARY KEY auto_increment,
    found_id INT NOT NULL UNIQUE, 
    student_id VARCHAR(12) NOT NULL,
    student_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    claim_date DATE NOT NULL,
    FOREIGN KEY (found_id) REFERENCES found_items(found_id)
);
