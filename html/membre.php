<?php
session_start();

if (!isset($_SESSION['user']))
{
  header('location: index.php?error=nolog');
  exit();
}
 ?>

 <!DOCTYPE html>
 <html>
 <head>

   <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"/>
   <meta http-equiv="content-type" content="text/css">
   <title>Ma première page avec du style</title>
   <link type="text/css" rel="stylesheet" href="/css/membre.css" media="all"/>
 </head>

 <body>
   <header>
     <h2 class="welcome">Bienvenue
        <?php
          echo $_SESSION['user'];
        ?> !!</h2>
     <h1 class="title"> CAMAGRU </h1>
     <div class="deco"><a href="deconnexion.php"> se deconnecter </a></div>
     <div class="profile"><a href="profile.php"> Profile</a></div>
   </header>
 <!-- Menu de navigation du site -->
 <main>



<form method="POST" enctype="multipart/form-data">
 <input type="file" name="myimage">
 <input type="submit" name="submit_image" value="Upload">
</form>
<br>
<br>
<?php

if (isset($_POST['submit_image']))
{
  $target_path = "images/";
  $target_path = $target_path.basename($_FILES['myimage']['name']);

  if (move_uploaded_file($_FILES['myimage']['tmp_name'], $target_path)) {

    $db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
    $db->setAttribute(PDO::ERRMODE_EXCEPTION);

    $sql = $db->prepare('INSERT INTO upload(path) VALUES(?)');
    if ($sql->execute(array($target_path)) == TRUE) {
      $_SESSION['path_img'] = $target_path;
      echo $target_path;
      echo "<br><img src=".$target_path." height=200 width=300 /><br>";
    }
    else {
      echo "Error:".$sql.$db->error;
  # code...
}

  }
}
?>
<br>
<br>
  <form action="membre.php" method="post">
    <input type="radio" name="type_filter" value="filter1" onclick="bascule('bmount')" ><img src="data/tail.png" height=50 width="80" />
    <input type="radio" name="type_filter" value="filter2" onclick="bascule('bmount')" ><img src="data/edward.png" height=50 width="80" />
    <input type="radio" name="type_filter" value="filter3" onclick="bascule('bmount')" ><img src="data/cadre.png" height=50 width="80" />
    <br>
    <input id="bmount" type="submit" name="submit_filter" value="Montage" />
  </form>
  <script type="text/javascript" language="javascript">
    document.getElementById('bmount').setAttribute("disabled","");
    function bascule(id)
    {
       if (document.getElementById(id).disabled == true)
       {
          document.getElementById(id).removeAttribute("disabled");
          document.getElementById(id).style.cursor = "pointer";
       }
       else
       document.getElementById(id).style.cursor = "pointer";
    }
  </script>
<?php
  if ($_POST['submit_filter'] && $_POST['submit_filter'] == "Montage") {

    if ($_POST['type_filter'] && !empty($_POST['type_filter'])) {

      if ($_POST['type_filter'] == "filter1") {
        $src = imagecreatefrompng("images/tail.png");
      }
      elseif ($_POST['type_filter'] == "filter2") {
        $src = imagecreatefrompng("images/edward.png");
      }
      else {
        $src = imagecreatefrompng("images/cadre.png");
      }
      $dest = imagecreatefromjpeg($_SESSION['path_img']);

      echo "Image load : ".$_SESSION['path_img'];
      $l_s = imagesx($src);
      $h_s = imagesy($src);
      $l_d = imagesx($dest);
      $h_d = imagesy($dest);
    /*  echo imagesx($src);
      echo "<br>";
      echo imagesy($src);
      echo "<br>";
      echo imagesx($dest);
      echo "<br>";
      echo imagesy($dest);*/

      $destination_x = $l_d - $l_s;
      $destination_y =  $h_d - $h_s;
    //  imagecopy($dest, $src, $destination_x, $destination_y, 0, 0, $l_s, $h_s);
      imagecopy($dest, $src, 0, 0, 0, 0, $l_s, $h_s);
      imagejpeg($dest,"images/test1.jpg");
      $target = "images/test1.jpg";
      echo "<br><img src=".$target." height=439px width=550px /><br>";
    }
  }
  else {
    echo "error montage !";
  }
 ?>
