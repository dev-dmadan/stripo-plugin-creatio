# Local Development Only

-- Remove commentary if you want build database from zero
# DROP DATABASE IF EXISTS `dev-stripo`;
# CREATE DATABASE `dev-stripo`;
# USE `dev-stripo`;

# End Local Development Only

-- Table Email
DROP TABLE IF EXISTS email;
CREATE TABLE IF NOT EXISTS email (
    id VARCHAR(255) NOT NULL UNIQUE,
    id_bpm VARCHAR(255) NOT NULL,
    name VARCHAR(255) DEFAULT NULL,
    html TEXT DEFAULT NULL,
    css TEXT DEFAULT NULL,
    html_css TEXT DEFAULT NULL,
    isTemplate TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT pk_email_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Table Increment Email
DROP TABLE IF EXISTS increment_email_id;
CREATE TABLE IF NOT EXISTS increment_email_id (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    last_increment INT UNSIGNED NOT NULL DEFAULT 0,
    
    CONSTRAINT pk_increment_email_id_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Tabel Config Stripo
DROP TABLE IF EXISTS config_stripo;
CREATE TABLE IF NOT EXISTS config_stripo (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_name VARCHAR(255),
    website VARCHAR(255),
    subscription_plan VARCHAR(255),
    creation_date DATE DEFAULT NULL,
    subscription_price DOUBLE(12,2) UNSIGNED DEFAULT NULL,
    pluginId VARCHAR(255),
    secretKey VARCHAR(255),

    CONSTRAINT pk_config_stripo_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Tabel Token Akses
DROP TABLE IF EXISTS access_token;
CREATE TABLE IF NOT EXISTS access_token (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    token TEXT,

    CONSTRAINT pk_access_token_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Tabel Merge Tags

-- Tabel Detail Merge Tags

-- Function get last increment
DROP FUNCTION IF EXISTS f_get_increment;
delimiter //
CREATE FUNCTION f_get_increment() RETURNS int 
DETERMINISTIC
BEGIN
  DECLARE last_increment_param int;

  SELECT last_increment INTO last_increment_param FROM increment_email_id LIMIT 1;
  UPDATE increment_email_id SET last_increment = (last_increment_param + 1);

  RETURN (last_increment_param + 1);
END //
delimiter ;

-- Seeder Config Stripo
INSERT INTO config_stripo 
    (project_name, website, subscription_plan, creation_date, subscription_price, pluginId, secretKey) 
VALUES
    -- plugin untuk dev
    ("PT. Inter Sistem Asia", "https://demo.lordraze.com/dev-stripo/", "FREE", "2018-08-29", 0, 
	 "8b2383303661484292deaa9bba011f7b", "34ce9da390fc49bfbd236930a29d233f"),
    --  plugin untuk production 
    ("bpmonline", "http://bpmonline.asia/", "STARTUP", "2018-09-18", 100, 
	 "18f2ef44142243efa50045d535486cd6", "201eafe108614367848c4f6dcb566287");

-- Seeder Access Token
INSERT INTO access_token (token) VALUES ('$2y$10$EFgwO03XRKtRd1Ca/3A02OWliR8FPCgIktNoYhkiT3VveqfBgrFa2');

-- Seeder Increment Email Id
INSERT INTO increment_email_id (last_increment) VALUES (0);