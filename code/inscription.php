<?php
session_start();

 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"/>
   <meta http-equiv="content-type" content="text/css">
   <title>Ma première page avec du style</title>
   <link type="text/css" rel="stylesheet" href="/css/inscription.css" media="all"/>
 </head>
 <body>
   <header>
     <h1> CAMAGRU </h1>
   </header>
 <!-- Menu de navigation du site -->
 <main>
   <h2>INSCRIPTION</h2>
   <form method="post" action="signin.php">
     nom d'utilisateur :<br>
     <input type="text" name="user"><br>
     adresse mail :<br>
     <input type="text" name="email"><br>
     mot de passe :<br>
     <input type="password" name="pwd"><br>
    <input type="submit" name="submit" value="Valider">
   </form>
   <a href="connexion.php">Pas encore inscrit ? </a>
 </main>

 </body>
 </html>
