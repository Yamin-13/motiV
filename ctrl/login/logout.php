<?php
session_start(); 

// détruit toutes les variables de session
$_SESSION = [];

// Redirige vers la page de connexion
header('Location: /ctrl/login/login-display.php');
exit();