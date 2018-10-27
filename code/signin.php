<?php

if (isset($_POST['submit']) && $_POST['submit'] == "Valider")
{
  $isset = isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pwd']);
  $empty = !empty($_POST['user']) && !empty($_POST['email']) && !empty($_POST['pwd']);

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
    $verify_user = $db->prepare('SELECT count(*) FROM login WHERE user = ?');
    $sql = $db->prepare('INSERT INTO login(user,pwd,email) VALUES(:user, :pwd , :email)');
    $verify = $db->prepare('SELECT count(*) FROM login WHERE user= ? AND pwd= ? AND email= ?');

    $verify_user->execute(array($_POST['user']));
    $result = $verify_user->fetch();

    if ($result[0] == 0)
    {
      $verify_user->closeCursor();

      $sql->execute(array(
        ':user' => $_POST['user'],
        ':pwd' => hash('sha256', $_POST['pwd']),
        ':email' => $_POST['email']
      ));

      $sql->closeCursor();

      $verify->execute(array(
        $_POST['user'] ,
        hash('sha256', $_POST['pwd']),
        $_POST['email']
      ));

      $data = $verify->fetch();

      if ($data[0] == 1)
      {
        session_start();
        $_SESSION['login'] = $_POST['user'];

        header('Location: membre.php');
        exit();
      }
      else
      {
        header('Location: inscription.php?error=write');
        exit();
      }
    }
    else
    {
      header('Location: inscription.php?error=login');
    }

    echo "CONNECT DB OK !";
    exit();
  }
  else
  {
    header('Location: inscription.php?error=champ');
    exit();// code...
  }
}
else
{
   header('Location: inscription.php?error=form');
   exit();
}

 ?>
