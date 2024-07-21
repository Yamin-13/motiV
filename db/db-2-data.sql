-- Mentionne le nom de la base de données à utiliser pour exécuter les commandes SQL qui suivent.
USE `motiv_db`;

INSERT INTO role (id, code, label ) VALUES
     (10, 'ADM', 'Admin')
     ,(20, 'EE', 'educational_establishment')
    ,(30, 'CH', 'city_hall')
    ,(40, 'P', 'partner')
    ,(50, 'ASSO', 'association')
    ,(60, 'YNG', 'young')
;