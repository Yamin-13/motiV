<?php

/**
 * retourne une connexion à la base de données.
 * 
 * @param array $params Paramètres de connexion (host, port, ...)
 * 
 * @return PDO Connexion à la base.
 */
function getConnection(array $params) : PDO
{
    $dataSourceName = 'mysql:host=' . ConfigDb::HOST . ';port=' . $params['port'] . ';dbname=' . $params['dbname'];
    $connection = new PDO($dataSourceName, $params['user'], $params['password']);

    // Configure la connexion pour afficher toutes les erreurs (quand il y en a)
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection;
}