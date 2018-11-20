<?php

if (isset($_POST['submit']) && $_POST['submit'] == "Valider") {
    $isset = isset($_POST['user']) && isset($_POST['pwd']);
    $empty = !empty($_POST['user']) && !empty($_POST['pwd']);

    if ($isset && $empty) {
        try {
<<<<<<< HEAD
            $db = new PDO('mysql:host=mysql;port=3306;dbname=camagru', 'root', 'pass');
=======
            $db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
>>>>>>> 16e81931029e301df0598731d0b8110a48a78ab8
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $verify_connexion = $db->prepare('SELECT id_user, user, pwd, email FROM login WHERE user = :user');
        $verify_connexion->bindParam(':user', $_POST['user'], PDO::PARAM_STR);
        $verify_connexion->execute(array(':user' => $_POST['user']));
        $result = $verify_connexion->fetch();

        $pwd_hash = hash('whirlpool', $_POST['pwd']);

        if (!$result) {
            header('location: index.php?error=1');
            exit();
        } else {
            if ($pwd_hash == $result['pwd']) {
                session_start();
                $_SESSION['id'] = $result['id_user'];
                $_SESSION['user'] = $result['user'];
                $_SESSION['email'] = $result['email'];
                header('location: membre.php');
                exit();
            } else {
                header('location: index.php?error=2');
            }
        }
    } else {
        header('location: index.php?error=1');
        exit();
    }
} else {
    header('Location: index.php?error=1');
    exit();
}
