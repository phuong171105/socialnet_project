-- =============================================================
-- SocialNet Application Database
-- =============================================================

-- Create the database
CREATE DATABASE IF NOT EXISTS socialnet
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE socialnet;

-- Create the account table
CREATE TABLE IF NOT EXISTS account (
  id          INT          NOT NULL AUTO_INCREMENT,
  username    VARCHAR(50)  NOT NULL UNIQUE,
  fullname    VARCHAR(150) NOT NULL,
  password    VARCHAR(255) NOT NULL,   -- stores bcrypt hash
  description TEXT         DEFAULT NULL,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: seed an initial admin-created user for quick testing
-- Password below is the bcrypt hash of "Admin@1234"
-- INSERT INTO account (username, fullname, password, description)
-- VALUES ('admin', 'Administrator', '$2y$12$...', 'Site administrator');
