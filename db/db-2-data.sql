-- Mentionne le nom de la base de données à utiliser pour exécuter les commandes SQL qui suivent.
USE `motiv_db`;

INSERT INTO role (id, code, label ) VALUES
     (10, 'ADM', 'Admin')
    ,(20, 'EE', 'educational_establishment')
    ,(25, 'MB_EE', 'educational_establishment_member')
    ,(30, 'CH', 'city_hall')
    ,(35, 'MB_CH', 'city_hall_member')
    ,(40, 'P', 'partner')
    ,(45, 'MB_P', 'partner_member')
    ,(50, 'ASSO', 'association')
    ,(55, 'MB_ASSO', 'association_member')
    ,(60, 'YNG', 'young')
;
