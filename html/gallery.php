<?php
session_start();

if (!isset($_SESSION['user']))
{
  header('location: index.php');
}

$db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$imagesParPage = 3;
$imagesTotalesReq = $db->prepare('SELECT ID_IMG FROM image');
$imagesTotalesReq->execute();
$imagesTotales = $imagesTotalesReq->rowCount();
$pagesTotales = ceil($imagesTotales/$imagesParPage);

if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $pagesTotales) {
  $_GET['page'] = intval($_GET['page']);
  $pageCourante = $_GET['page'];
}
else {
  $pageCourante = 1;
}

$depart = ($pageCourante-1)*$imagesParPage;


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
  <div id="bar_nav">
    <ul>
      <li><a class="active" href="#home">Home</a></li>
      <li><a href="#news">News</a></li>
      <li><a href="#contact">Contact</a></li>
      <li><a href="#about">About</a></li>
    </ul>
  </div>
<!-- Menu de navigation du site -->
<main id="main_gallery">
  <h2>Gallery</h2>
  <div><a href="membre.php">Retour a l'espace membre</a></div> <br> <br>
  <?php
  $images = $db->prepare('SELECT * FROM image ORDER BY DATE_IMG LIMIT '.$depart.','.$imagesParPage);
  $images->execute();
  while ($result = $images->fetch()) {

    $likes = $db->prepare('SELECT ID_LIKES FROM T_LIKES WHERE ID_IMG = ?');
    $likes->execute(array($result['ID_IMG']));
    $likes = $likes->rowCount();

      echo "<div id='div_gallery'><a href='review.php?id_img=".$result['ID_IMG']."&page=".$pageCourante."' ><img id='img_save' src=".$result['PATH_IMG']." height=228px width=404px /></a><br>  ";
      echo "<a class='like_gal' href='php/action.php?id=".$result['ID_IMG']."&page=".$pageCourante."'>J'aime</a> (".$likes.")</div>";

  }
   ?>
   <br><br>
   <div class="pagination">
   <?php
   for($i=1;$i<=$pagesTotales;$i++){
     if ($i == $pageCourante) {
       echo '<a class="active" href="gallery.php?page='.$i.'">'.$i.' </a>';
     }
     else {
     echo '<a href="gallery.php?page='.$i.'">'.$i.' </a>';


      }
     }
    ?>
  </div>
</main>
</body>
</html>
