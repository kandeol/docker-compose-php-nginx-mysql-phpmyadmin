<?php
session_start();

if (isset($_SESSION['user']))
{
  header('location: membre.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"/>
  <meta http-equiv="content-type" content="text/css">
  <title>Ma première page avec du style</title>
  <link type="text/css" rel="stylesheet" href="/css/index.css" media="all"/>
</head>
<body>
  <header>
    <h1 class="title"> CAMAGRU </h1>
  </header>
<!-- Menu de navigation du site -->
<main>
  <h2>CONNEXION</h2>
  <form action="connexion.php" method="post">
    nom d'utilisateur :<br>
    <input type="text" name="user"><br>
    mot de passe :<br>
    <input type="text" name="pwd"><br>
    <input type="submit" name="submit" value="Valider">
  </form>
  <a href="inscription.php">Pas encore inscrit ?</a>
</main>
</body>
</html>
