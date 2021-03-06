CREATE TABLE administrators (
  name varchar(64) NOT NULL,
  username varchar(64) UNIQUE NOT NULL,
  email varchar(255) DEFAULT NULL,
  password varchar(255) NOT NULL,
  permissions text,
  root boolean NOT NULL DEFAULT '0',
  id SERIAL,
  PRIMARY KEY (id)
);

CREATE TABLE categories(
	title VARCHAR(100) NOT NULL,
	parent INT,
	id SERIAL,
	FOREIGN KEY(parent) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE blog(
	title VARCHAR(100) NOT NULL,
	preview TEXT,
	body TEXT NOT NULL,
	slug VARCHAR(255) NOT NULL,
	head TEXT,
	category INT,
	tags TEXT,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id SERIAL,
	FOREIGN KEY(category) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE blogviews(
	post INT NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	ip VARCHAR(15) NOT NULL,
	id SERIAL,
	FOREIGN KEY(post) REFERENCES blog(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comments(
	name VARCHAR(128) NOT NULL,
	body TEXT NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	post INT NOT NULL,
	reply INT,
	id SERIAL,
	FOREIGN KEY(post) REFERENCES blog(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(reply) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE messages(
	name VARCHAR(128) NOT NULL,
	email VARCHAR(255),
	phone VARCHAR(11),
	subject VARCHAR(128),
	body TEXT NOT NULL,
	isread BOOLEAN NOT NULL DEFAULT false,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id SERIAL,
	PRIMARY KEY(id)
);

CREATE TABLE tags(
	title VARCHAR(60) NOT NULL,
	id SERIAL,
	PRIMARY KEY(id)
);

CREATE TABLE users(
	name VARCHAR(64) NOT NULL,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	address VARCHAR(255),
	number VARCHAR(10) DEFAULT 'S/N',
	addresscomplement VARCHAR(64),
	neighborhood VARCHAR(64),
	cep VARCHAR(8),
	city VARCHAR(64),
	state VARCHAR(2),
	phone VARCHAR(11),
	id SERIAL,
	PRIMARY KEY(id)
);

CREATE TABLE mailing(
	email VARCHAR(255) UNIQUE NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id SERIAL,
	PRIMARY KEY(id)
);

CREATE TABLE banners (
  title VARCHAR(128) NOT NULL,
  since TIMESTAMP,
  until TIMESTAMP,
  permanent BOOLEAN NOT NULL DEFAULT false,
  src VARCHAR(255) NOT NULL,
  position INT,
  link VARCHAR(255),
  id SERIAL,
  PRIMARY KEY (id)
);

/* Apenas para módulos de pagamento */
CREATE TABLE pagseguroconfig(
	email VARCHAR(255) NOT NULL,
	token VARCHAR(255) NOT NULL,
	title VARCHAR(60) DEFAULT 'Conta sem título',
	id SERIAL,
	PRIMARY KEY(id)
);

CREATE TABLE pagseguroorders(
	reference VARCHAR(32) NOT NULL,
	orderitems TEXT NOT NULL,
	status INT NOT NULL,
	id SERIAL,
	PRIMARY KEY(id)
);