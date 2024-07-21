-- Mentionne le nom de la base de données à utiliser pour exécuter les commandes SQL qui suivent.
USE `motiv_db`;

INSERT INTO role (id, code, label ) VALUES
     (10, 'ADM', 'Admin')
     ,(20, 'C', 'contributor')
    ,(30, 'SA', 'sampleUser')
;