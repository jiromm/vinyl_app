CREATE TABLE vinyl_app.category
(
    id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    `order` INT NOT NULL
);

CREATE TABLE vinyl_app.house
(
	id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL
);

CREATE TABLE vinyl_app.fence
(
	id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	category_id INT(11) UNSIGNED NOT NULL,
	name VARCHAR(255) NOT NULL,
	CONSTRAINT fence_category_id_fk FOREIGN KEY (category_id) REFERENCES category (id)
);

CREATE TABLE vinyl_app.user
(
	id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(32) NOT NULL
);

INSERT INTO user set username = 'jiromm', password = md5('dominatrix');
