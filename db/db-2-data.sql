-- Mentionne le nom de la base de données à utiliser pour exécuter les commandes SQL qui suivent.
USE `motiv_db`;

INSERT INTO role (id, code, label ) VALUES
     (10, 'ADM', 'Admin')
    ,(20, 'EE', 'educational_establishment')
    ,(25, 'MB_EE', 'educational_establishment_member')
    ,(27, 'PROF', 'professor')
    ,(30, 'CH', 'city_hall')
    ,(35, 'MB_CH', 'city_hall_member')
    ,(40, 'P', 'partner')
    ,(45, 'MB_P', 'partner_member')
    ,(50, 'ASSO', 'association')
    ,(55, 'MB_ASSO', 'association_member')
    ,(60, 'YNG', 'young')
;

INSERT INTO site_configuration (key_name, key_value, description) VALUES
    ('points_per_hour', '100', 'Nombre de points attribués par heure pour les missions')
    ,('ine_validation_points', '1000', 'Nombre de points attribués pour la validation du numéro INE')
;

INSERT INTO category (id, name, image_filename) VALUES
     (1, 'Événements et Activités', 'image-categorie-evenements.webp')
    ,(2, "Bons d\'Achat", 'image-categorie-bons.webp')
    ,(3, 'Produits et Gadgets', 'image-categorie-produits.webp')
    ,(4, 'Repas et Boissons', 'image-categorie-repas.webp')
    ,(5, 'Sports et Loisirs', 'image-categorie-sports.webp')
    ,(6, 'Voyages et Séjours', 'image-categorie-voyages.webp')
    ,(7, 'Éducation et Apprentissage', 'image-categorie-education.webp')
    ,(8, 'Bien-être et Santé', 'image-categorie-bien-etre.webp')
    ,(9, 'Culture et Divertissement', 'image-categorie-culture.webp')
;