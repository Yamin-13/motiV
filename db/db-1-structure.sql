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
    ine_number varchar(20) NOT NULL,
    registration_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_connexion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    profile_complete TINYINT(1) NOT NULL DEFAULT 0,
    point varchar(20) DEFAULT 0,
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
    idCategory bigint(20) NOT NULL,
    idCityHall bigint(20) NULL,
    idPartner bigint(20) NULL
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

CREATE TABLE city_hall_user (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser BIGINT(20) NOT NULL,
    role ENUM('admin', 'member') NOT NULL,
    idCityHall BIGINT(20) NOT NULL
)
;

CREATE TABLE educational_establishment (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    phone_number varchar(50),
    address varchar(100) NOT NULL,
    RNE_number varchar(100) NOT NULL,
    unique_code varchar(10) NOT NULL UNIQUE,
    image_filename varchar(255),
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE educational_establishment_user (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser BIGINT(20) NOT NULL,
    role ENUM('admin', 'member') NOT NULL,
    idEducationalEstablishment BIGINT(20) NOT NULL
)
;

CREATE TABLE professor_user (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser BIGINT(20) NOT NULL,
    idEducationalEstablishment BIGINT(20) NOT NULL,
    class_name varchar(50) NOT NULL
)
;

CREATE TABLE student (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ine_number varchar(20) NOT NULL,
    idProfessor BIGINT(20) NOT NULL,
    idEducationalEstablishment BIGINT(20) NOT NULL,
    status ENUM('pending', 'validated') NOT NULL DEFAULT 'pending'
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

CREATE TABLE partner_user (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser bigint(20) NOT NULL,
    role ENUM('partner', 'member') NOT NULL,
    idPartner bigint(20) NOT NULL
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
    start_date_mission DATETIME NOT NULL,
    end_date_mission DATETIME NOT NULL,
    image_filename varchar(255),
    status ENUM('open', 'complete', 'accomplished') NOT NULL DEFAULT 'open',
    number_of_places INT NOT NULL,
    idUser bigint(20) NOT NULL,
    idAssociation bigint(20) NOT NULL
)
;

CREATE TABLE mission_registration (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idMission BIGINT(20) NOT NULL,
    idUser BIGINT(20) NOT NULL,
    registration_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cancellation_reason VARCHAR(255) NULL,
    marked_absent TINYINT(1) DEFAULT 0,
    status ENUM('registered', 'canceled', 'completed') NOT NULL DEFAULT 'registered'
)
;

CREATE TABLE point (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    number_of_points INT NOT NULL,
    reason varchar(1500) NOT NULL,
    date_of_grant timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    idUser bigint(20) NOT NULL
)
;

CREATE TABLE site_configuration (
    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(50) UNIQUE NOT NULL,
    key_value VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL 
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
    ,idAssociation BIGINT(20) NULL
    ,idPartner BIGINT(20) NULL
    ,idEducationalEstablishment BIGINT(20) NULL  
    ,idCityHall BIGINT(20) NULL  
    ,idRole BIGINT(20) NOT NULL
    ,entity_type ENUM('association', 'partner', 'educational', 'city_hall') NOT NULL  
)
;

CREATE TABLE password_resets (
    id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,email VARCHAR(50) NOT NULL
    ,token VARCHAR(32) NOT NULL
    ,expiry TIMESTAMP NOT NULL
)
;

-- ----------
-- CONTRAINTES
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
    ,ADD CONSTRAINT `fk_reward_city_hall` FOREIGN KEY(idCityHall) REFERENCES city_hall(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_reward_partner` FOREIGN KEY(idPartner) REFERENCES partner(id) ON DELETE CASCADE
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

ALTER TABLE city_hall_user
    ADD CONSTRAINT `fk_city_hall_user_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_city_hall_user_city_hall` FOREIGN KEY(idCityHall) REFERENCES city_hall(id) ON DELETE CASCADE
;

ALTER TABLE educational_establishment
    ADD CONSTRAINT `u_educational_establishment_name` UNIQUE(name)
    ,ADD CONSTRAINT `u_educational_establishment_email` UNIQUE(email)
    ,ADD CONSTRAINT `fk_educational_establishment_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE educational_establishment_user
    ADD CONSTRAINT `fk_educational_establishment_user_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_educational_establishment_user_educational_establishment` FOREIGN KEY(idEducationalEstablishment) REFERENCES educational_establishment(id) ON DELETE CASCADE
;

ALTER TABLE partner
    ADD CONSTRAINT `u_partner_name` UNIQUE(name)
    ,ADD CONSTRAINT `fk_partner_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
;

ALTER TABLE partner_user
    ADD CONSTRAINT `fk_partner_user_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_partner_user_partner` FOREIGN KEY(idPartner) REFERENCES partner(id) ON DELETE CASCADE
;

ALTER TABLE mission
    ADD CONSTRAINT `fk_mission_user` FOREIGN KEY(idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_mission_association` FOREIGN KEY(idAssociation) REFERENCES association(id) ON DELETE CASCADE
;

ALTER TABLE mission_registration
    ADD CONSTRAINT `fk_mission_registration_mission` FOREIGN KEY (idMission) REFERENCES mission(id) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_mission_registration_user` FOREIGN KEY (idUser) REFERENCES user(id) ON DELETE CASCADE
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
    ,ADD CONSTRAINT `fk_invitation_educational_establishment` FOREIGN KEY (idEducationalEstablishment) REFERENCES educational_establishment(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_invitation_city_hall` FOREIGN KEY (idCityHall) REFERENCES city_hall(id) ON DELETE CASCADE 
    ,ADD CONSTRAINT `fk_invitation_role` FOREIGN KEY(idRole) REFERENCES role(id) ON DELETE CASCADE
;

ALTER TABLE professor_user
    ADD CONSTRAINT `fk_professor_user_user` FOREIGN KEY (idUser) REFERENCES user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_professor_user_educational_establishment` FOREIGN KEY (idEducationalEstablishment) REFERENCES educational_establishment(id) ON DELETE CASCADE
;

ALTER TABLE student
    ADD CONSTRAINT `fk_student_professor` FOREIGN KEY (idProfessor) REFERENCES professor_user(id) ON DELETE CASCADE
    ,ADD CONSTRAINT `fk_student_educational_establishment` FOREIGN KEY (idEducationalEstablishment) REFERENCES educational_establishment(id) ON DELETE CASCADE
;