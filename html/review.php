<?php
session_start();

if (!isset($_SESSION['user']))
{
  header('location: index.php');
}

$db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id_img']) && !empty($_GET['id_img'])) {
  $get_id_img = htmlspecialchars($_GET['id_img']);
  $get_p_page = $_GET['page'];

  $likes = $db->prepare('SELECT ID_LIKES FROM T_LIKES WHERE ID_IMG = ?');
  $likes->execute(array($get_id_img));
  $likes = $likes->rowCount();
}
else {
  header('location: gallery.php?page=1');
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
<main id="main_review">
  <div id="return_gallery"><a href="gallery.php?page=<?= $get_p_page?>">Retour sur la gallery</a></div>
  <h2>REVIEW</h2>
  <br><br>
  <?php

  $id = $_GET['id_img'];
  $sql = $db->prepare('SELECT PATH_IMG FROM image WHERE ID_IMG = ?');
  $sql->execute(array($_GET['id_img']));
  $path_img = $sql->fetch();

  echo "<img src='".$path_img['PATH_IMG']."' height=228px width=404px />";

   ?>
   <br><br>
   <a href="php/action.php?id=<?= $id?>&page=<?= $get_p_page?>">J'aime</a> (<?= $likes ?>)

</main>
</body>
</html>
