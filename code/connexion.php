<?php

if (isset($_POST['submit']) && $_POST['submit'] == "Valider")
{
  $isset = isset($_POST['user']) && isset($_POST['pwd']);
  $empty = !empty($_POST['user']) && !empty($_POST['pwd']);

  if ($isset && $empty)
  {
    try
    {
      $db = new PDO('mysql:host=mysql;port=3306;dbname=camagru', 'root', 'pass');
    }
    catch (\Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    $verify_connexion = $db->prepare('SELECT id, pwd FROM login WHERE user = :user');
    $verify_connexion->execute(array(':user' => $_POST['user']));
    $result = $verify_connexion->fetch();

    $pwd_hash = hash('sha256', $_POST['pwd']);

    if (!$result)
    {
        header('location: index.php?error=w_id');
        echo "Mauvais identifants !";
    }
    else
    {
      if ($pwd_hash == $result['pwd'])
      {
        session_start();
        $_SESSION['id'] = $result['id'];
        $_SESSION['user'] = $result['user'];
        echo "vous etes connecte !";
        exit();
      }
      else
      {
        header('location: index.php?error=w_pwd');
        echo "mauvais mot de passe !";
      }
    }
}
}
else
{
   header('Location: index.php?error=form_connex');
   exit();
}

?>
