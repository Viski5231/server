-- Internal telephony schema (MySQL)
-- Database: mvc (see config/db.php)

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NULL,
  login VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'sysadmin',
  PRIMARY KEY (id),
  UNIQUE KEY users_login_unique (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS divisions (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  type VARCHAR(150) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS premises (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  type VARCHAR(150) NOT NULL,
  division_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY premises_division_id_index (division_id),
  CONSTRAINT premises_division_id_fk FOREIGN KEY (division_id) REFERENCES divisions(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS phones (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  number VARCHAR(50) NOT NULL,
  premise_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY phones_number_unique (number),
  KEY phones_premise_id_index (premise_id),
  CONSTRAINT phones_premise_id_fk FOREIGN KEY (premise_id) REFERENCES premises(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS subscribers (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  lastname VARCHAR(100) NOT NULL,
  firstname VARCHAR(100) NOT NULL,
  patronymic VARCHAR(100) NOT NULL,
  birthdate DATE NOT NULL,
  division_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY subscribers_division_id_index (division_id),
  CONSTRAINT subscribers_division_id_fk FOREIGN KEY (division_id) REFERENCES divisions(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Phone assignment: one phone belongs to at most one subscriber, subscriber can have many phones
CREATE TABLE IF NOT EXISTS subscriber_phone (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  subscriber_id INT UNSIGNED NOT NULL,
  phone_id INT UNSIGNED NOT NULL,
  assigned_at DATETIME NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY subscriber_phone_phone_id_unique (phone_id),
  KEY subscriber_phone_subscriber_id_index (subscriber_id),
  CONSTRAINT subscriber_phone_subscriber_id_fk FOREIGN KEY (subscriber_id) REFERENCES subscribers(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT subscriber_phone_phone_id_fk FOREIGN KEY (phone_id) REFERENCES phones(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

