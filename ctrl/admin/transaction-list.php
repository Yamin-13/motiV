<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/transaction.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Liste des échanges | MotiV – La plateforme qui valorise l'effort";

// Vérifie que l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 10) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupére toute les transaction
$transactions = getAllTransactions($dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/transaction-list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';