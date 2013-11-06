DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `users_extra`;

CREATE TABLE users (
	user_id INT(11) NOT NULL AUTO_INCREMENT,
	user_name VARCHAR(18) NOT NULL,
	password CHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	email_code VARCHAR(100),
	time INT(11) NOT NULL,
	confirmed INT(11) DEFAULT 0,
	ip VARCHAR(32),
	PRIMARY KEY (user_id),
	UNIQUE INDEX (email, user_name)
);

CREATE TABLE users_extra (
	user_id INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(25),
	last_name VARCHAR(25),
	address VARCHAR(80),
	city VARCHAR(30),
	province CHAR(2),
	postcode CHAR(7),
	profile_picture_url VARCHAR(250),
	registered INT(11) DEFAULT 0,
	PRIMARY KEY (user_id)
);