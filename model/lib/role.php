<?php
function getReadableRole($role) {
    $roleMapping = [
        'ADM' => 'Admin',
        'association' => 'Association',
        'MB_ASSO' => 'Membre d\'Association',
        'city_hall' => 'Mairie',
        'MB_CH' => 'Membre de Mairie',
        'educational_establishment' => 'Établissement Scolaire',
        'MB_EE' => 'Membre d\'Établissement Scolaire',
        'professor' => 'Professeur',
        'partner' => 'Partenaire',
        'MB_P' => 'Membre de Partenaire',
        'young' => 'Jeune',
    ];
// ca va envoiyé le role lisible ou le role d'origine s'il n'existe pas dans le tableau
    return $roleMapping[$role] ?? $role; 
}