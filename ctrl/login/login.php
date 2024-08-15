<?php
session_start(); // ca initialise une session et permet à $_SESSION de fonctionner (de stocker dans les coockies) 
// Ouvre une connexion à la Base de données
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';

// vérifie si le formulaire de connexion a été soumis
if (isset($_POST['email']) && isset($_POST['password'])) {

    // ca récupére les informations d'identification du formulaire envoyé par POST
    $form = [];
    $form['email'] = htmlspecialchars($_POST['email']);
    $form['password'] = htmlspecialchars($_POST['password']);

    // ca se connecte à la base de données avec ces parametres
    $dbConnection = getConnection($dbConfig);

    // la fonction getUser retourne un tableau ou false. et le résultat est stocké dans UserDAta avec
    // les informations d'identification et la connexion à la base de données ($dbConnection)
    $userData = getUser($form['email'], $form['password'], $dbConnection);


    // Pour vérifier les informations d'identification
    if ($userData !== null) {  // !== c'est l'opérateur strict pour vérifié si userdata retourne null (varDump pour verifier)
        // Si l'utilisateur existe et que le mot de passe est correct...
        // ...Alors ca crée une session pour l'utilisateur et le redirige vers la page welcome

        $_SESSION['user'] = $userData;  // <=======CEST ICI QUE LE STOCKAGE DE LUTILISATEUR SE FAIT DANS SESSION 

        switch ($userData['idRole']) {
            case '10':
                header('Location: /ctrl/admin/profile.php');
                break;
            case '20':
                header('Location: /ctrl/profile/display.php');
                break;
            case '25':
                header('Location: /ctrl/profile/display.php');
                break;
            case '27':
                header('Location: /ctrl/profile/display.php');
                break;
            case '30':
                header('Location: /ctrl/profile/display.php');
                break;
            case '35':
                header('Location: /ctrl/profile/display.php');
                break;
            case '40':
                header('Location: /ctrl/profile/display.php');
                break;
            case '45':
                header('Location: /ctrl/profile/display.php');
                break;
            case '50':
                header('Location: /ctrl/profile/display.php');
                break;
            case '55':
                header('Location: /ctrl/profile/display.php');
                break;
            case '60':
                header('Location: /ctrl/home/welcome.php');
                break;
            default:
                header('Location: /ctrl/home/welcome.php');
                break;
        }
        exit();
    } else {
        //message d'erreur qui s'affiche et ...
        $_SESSION['error'] = 'Identifiants incorrects. Veuillez réessayer.';

        // ...ca redirige vers la page de login
        header('Location: /ctrl/login/login-display.php');
        exit();
    }
}
