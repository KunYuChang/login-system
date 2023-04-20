create database mvclogin;

CREATE TABLE USERS (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(50), 
    email VARCHAR(255) UNIQUE, 
    password_hash VARCHAR(255)
);

CREATE TABLE remembered_logins (
    token_hash VARCHAR(64) PRIMARY KEY,
    user_id INT,
    expires_at DATETIME
);

CREATE INDEX idx_user_id ON remembered_logins(user_id);

ALTER TABLE remembered_logins ADD CONSTRAINT fk_user_id
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE USERS
ADD COLUMN password_reset_hash VARCHAR(64) UNIQUE DEFAULT NULL,
ADD COLUMN password_reset_expires_at DATETIME DEFAULT NULL;

ALTER TABLE USERS
ADD COLUMN activation_hash VARCHAR(64) UNIQUE DEFAULT NULL,
ADD COLUMN is_active BOOLEAN DEFAULT 0;