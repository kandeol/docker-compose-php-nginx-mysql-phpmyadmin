<?php
session_start();
try {
<<<<<<< HEAD
    $db = new PDO('mysql:host=mysql;port=3306;dbname=camagru', 'root', 'pass');
=======
    $db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
>>>>>>> 16e81931029e301df0598731d0b8110a48a78ab8
} catch (\Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sql = $db->prepare('SELECT ID_USER FROM image WHERE ID_IMG = ?');
$sql->bindParam(1, $_GET['id_i'], PDO::PARAM_INT);
$sql->execute(array($_GET['id_i']));
$result = $sql->fetch();
$sql->closeCursor();

if ($_SESSION['id'] == $result['ID_USER']) {
    $sql = $db->prepare('DELETE FROM T_LIKES WHERE ID_IMG = ?');
    $sql->bindParam(1, $_GET['id_i'], PDO::PARAM_INT);
    $sql->execute(array($_GET['id_i']));
    $sql->closeCursor();

    $sql = $db->prepare('DELETE FROM T_COM WHERE ID_IMG = ?');
    $sql->bindParam(1, $_GET['id_i'], PDO::PARAM_INT);
    $sql->execute(array($_GET['id_i']));
    $sql->closeCursor();

    $sql = $db->prepare('DELETE FROM image WHERE ID_IMG = ?');
    $sql->bindParam(1, $_GET['id_i'], PDO::PARAM_INT);
    $sql->execute(array($_GET['id_i']));
    $sql->closeCursor();

    header('Location: membre.php?error=1');
    exit();
} else {
    header('Location: membre.php?error=2');
}
