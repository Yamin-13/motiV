DROP DATABASE IF EXISTS `motiv_db`;
CREATE DATABASE IF NOT EXISTS `motiv_db`;
USE `motiv_db`;

-- -------------
-- TABLES
-- -------------

CREATE TABLE role (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code varchar(50) NOT NULL,
    label varchar(50) NOT NULL
)
;

CREATE TABLE user (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) UNIQUE,
    email varchar(50) NOT NULL UNIQUE,
    first_name varchar(50),
    date_of_birth varchar(20),
    address varchar(100),
    password varchar(100) NOT NULL,
    avatar_filename varchar(255),
    registration_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_connexion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    idRole bigint(20)
)
;

CREATE TABLE reward (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    date timestamp NOT NULL,
    description varchar(2500) NOT NULL,
    reward_price varchar(50) NOT NULL,
    quantity_available varchar(50) NOT NULL,
    image_filename varchar(255),
    idUser bigint(20) NOT NULL,
    idCategory bigint(20) NOT NULL
)
;

CREATE TABLE comment (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    text varchar(1500) NOT NULL,
    date timestamp NOT NULL,
    idReward bigint(20) NOT NULL,
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE transaction (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    transaction_date timestamp NOT NULL,
    number_of_points varchar(50) NOT NULL,
    idReward bigint(20) NOT NULL,
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE category (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    image_filename varchar(255)
)
;

CREATE TABLE city_hall (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    phone_number varchar(50),
    address varchar(100),
    image_filename varchar(255),
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE educational_establishment (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    phone_number varchar(50),
    address varchar(100) NOT NULL,
    NIE_number varchar(100) NOT NULL,
    image_filename varchar(255),
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE partner (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    email varchar(50) UNIQUE,
    address varchar(100),
    siret_number varchar(100) NOT NULL,
    image_filename varchar(255),
    idUser bigint(20) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'
)
;

CREATE TABLE association (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    description varchar(1500),
    phone_number varchar(50),
    address varchar(100),
    RNE_number varchar(100) NOT NULL,
    image_filename varchar(255),
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE association_user (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser bigint(20) NOT NULL,
    role ENUM('admin', 'member') NOT NULL,
    idAssociation bigint(20) NOT NULL
)
;

CREATE TABLE mission (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar(100) NOT NULL,
    description varchar(1500) NOT NULL,
    date timestamp NOT NULL,
    point_award varchar(50) NOT NULL,
    start_date_mission varchar(50) NOT NULL,
    end_date_mission varchar(50) NOT NULL,
    image_filename varchar(255),
    idUser bigint(20) NOT NULL,
    idAssociation bigint(20) NOT NULL
)
;

CREATE TABLE point (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    number_of_points varchar(20) NOT NULL,
    reason varchar(1500) NOT NULL,
    date_of_grant timestamp NOT NULL,
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE rejections (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    entity_type ENUM('association', 'partner') NOT NULL,
    reason TEXT NOT NULL,
    entity_id BIGINT(20) NOT NULL
)
;

CREATE TABLE message (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE invitation (
     id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,email VARCHAR(50) NOT NULL
    ,token VARCHAR(32) NOT NULL
    ,expiry TIMESTAMP NOT NULL
    ,idAssociation BIGINT(20) DEFAULT NULL
    ,idPartner BIGINT(20) DEFAULT NULL
    ,entity_type ENUM('association', 'partner') NOT NULL
)
;

-- ----------
-- CONTRAINT
-- ----------

ALTER TABLE role
    ADD CONSTRAINT `u_role_code` UNIQUE(code)
    ,ADD CONSTRAINT `u_role_label` UNIQUE(label)
;

ALTER TABLE user
    ADD CONSTRAINT `u_user_name` UNIQUE(name)
    ,ADD CONSTRAINT `u_user_email` UNIQUE(email)
    ,ADD CONSTRAINT `fk_user_role` FOREIGN KEY(idRole) REFERENCES role(id)
;

ALTER TABLE reward
    ADD CONSTRAINT `fk_reward_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_reward_category` FOREIGN KEY(idCategory) REFERENCES category(id)
;

ALTER TABLE comment
    ADD CONSTRAINT `fk_comment_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_comment_reward` FOREIGN KEY(idReward) REFERENCES reward(id)
;

ALTER TABLE transaction
    ADD CONSTRAINT `fk_transaction_reward` FOREIGN KEY(idReward) REFERENCES reward(id)
    ,ADD CONSTRAINT `fk_transaction_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE city_hall
    ADD CONSTRAINT `u_city_hall_name` UNIQUE(name)
    ,ADD CONSTRAINT `fk_city_hall_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE educational_establishment
    ADD CONSTRAINT `u_educational_establishment_name` UNIQUE(name)
    ,ADD CONSTRAINT `u_educational_establishment_email` UNIQUE(email)
    ,ADD CONSTRAINT `fk_educational_establishment_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE partner
    ADD CONSTRAINT `u_partner_name` UNIQUE(name)
    ,ADD CONSTRAINT `fk_partner_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE mission
    ADD CONSTRAINT `fk_mission_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_mission_association` FOREIGN KEY(idAssociation) REFERENCES association(id)
;

ALTER TABLE association
    ADD CONSTRAINT `u_association_name` UNIQUE(name)
    ,ADD CONSTRAINT `u_association_email` UNIQUE(email)
    ,ADD CONSTRAINT `fk_association_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE point
    ADD CONSTRAINT `fk_point_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE association_user
    ADD CONSTRAINT `fk_association_user_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_association_user_association` FOREIGN KEY(idAssociation) REFERENCES association(id)
;

ALTER TABLE message
    ADD CONSTRAINT `fk_message_user` FOREIGN KEY (idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE rejections
    ADD CONSTRAINT `fk_rejection_association` FOREIGN KEY (entity_id) REFERENCES association(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_rejection_partner` FOREIGN KEY (entity_id) REFERENCES partner(id) ON DELETE CASCADE
;

ALTER TABLE invitation
     ADD CONSTRAINT `fk_invitation_association` FOREIGN KEY (idAssociation) REFERENCES association(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_invitation_partner` FOREIGN KEY (idPartner) REFERENCES partner(id) ON DELETE CASCADE
;