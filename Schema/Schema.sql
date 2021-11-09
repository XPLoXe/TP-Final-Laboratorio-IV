CREATE DATABASE IF NOT EXISTS University;

USE University;

CREATE TABLE UserRoles (
	user_role_id INT AUTO_INCREMENT,
	description VARCHAR(50),
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_role_id)
);

CREATE TABLE Users (
	user_id INT AUTO_INCREMENT,
	user_role_id INT,
	email NVARCHAR(50) NOT NULL,
	user_password NVARCHAR(64) NOT NULL,
	associated_id INT,
	first_name NVARCHAR(50),
	last_name NVARCHAR(50),
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_role_id) REFERENCES UserRoles (user_role_id)
);

CREATE TABLE Companies (
	company_id INT AUTO_INCREMENT,
	name NVARCHAR(50) NOT NULL,
	year_of_foundation YEAR NOT NULL,
	city VARCHAR(100) NOT NULL,
	description NVARCHAR(1000) NOT NULL,
	logo MEDIUMTEXT DEFAULT NULL,
	email NVARCHAR(50) NOT NULL,
	phone_number VARCHAR(20) NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (company_id)
);

CREATE TABLE Careers (
	career_id INT,
	description VARCHAR(100),
	active BOOL NOT NULL,
	PRIMARY KEY (career_id)
);

CREATE TABLE JobPositions (
	job_position_id INT,
	description VARCHAR(50) NOT NULL,
    career_id INT NOT NULL,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (job_position_id),
    FOREIGN KEY (career_id) REFERENCES Careers (career_id)
);

CREATE TABLE JobOffers (
	job_offer_id INT AUTO_INCREMENT,
	company_id INT NOT NULL,
	job_position_id INT,
	user_id INT DEFAULT NULL,
	description NVARCHAR(3000) NOT NULL,
	publication_date DATE NOT NULL,
	expiration_date DATE,
	active BOOL NOT NULL DEFAULT true,
	PRIMARY KEY (job_offer_id),
	FOREIGN KEY (company_id) REFERENCES Companies (company_id),
	FOREIGN KEY (job_position_id) REFERENCES JobPositions (job_position_id),
	FOREIGN KEY (user_id) REFERENCES Users (user_id)
);