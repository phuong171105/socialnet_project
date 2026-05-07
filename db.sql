-- =============================================================
-- SocialNet Application Database
-- Student: Nguyen Van Phuong | ID: 20225678
-- =============================================================

CREATE DATABASE IF NOT EXISTS socialnet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE socialnet;

-- Table: account (User accounts)
CREATE TABLE IF NOT EXISTS account (
  id          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username    VARCHAR(50)  NOT NULL UNIQUE,
  fullname    VARCHAR(150) NOT NULL,
  password    VARCHAR(255) NOT NULL,   -- Stores bcrypt hash
  description TEXT         DEFAULT NULL,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table: post (Status updates/News feed)
CREATE TABLE IF NOT EXISTS post (
  id         INT      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id    INT      NOT NULL,
  content    TEXT     NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES account(id) ON DELETE CASCADE
) ENGINE=InnoDB;
