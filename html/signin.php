<?php

if (isset($_POST['submit']) && $_POST['submit'] == "Valider")
{
  $isset = isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pwd']);
  $empty = !empty($_POST['user']) && !empty($_POST['email']) && !empty($_POST['pwd']);

  if ($isset && $empty)
  {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
      echo "erreur format adresse mail";
      exit();
    }
    try
    {
      $db = new PDO('mysql:host=localhost;port=3306;dbname=camagru', 'root', 'pass');
    }
    catch (\Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    $longueurKey = 15;
    $key = "";
    for($i=1;$i<$longueurKey;$i++)
    {
      $key .= mt_rand(0,9);
    }

    $verify_user = $db->prepare('SELECT count(*) FROM login WHERE user = ?');
    $verify_email = $db->prepare('SELECT count(*) FROM login WHERE email = ?');
    $sql = $db->prepare('INSERT INTO login(user,pwd,email,confirmkey,confirme) VALUES(?, ?, ?, ?, ?)');
    $verify = $db->prepare('SELECT count(*) FROM login WHERE user= ? AND pwd= ? AND email= ? AND confirmkey= ?');



    $verify_user->execute(array($_POST['user']));
    $verify_email->execute(array($_POST['email']));
    $result_user = $verify_user->fetch();
    $result_email = $verify_email->fetch();
    if ($result_user[0] == 0 && $result_email[0] == 0)
    {
  //    $verify_user->closeCursor();
    //  $verify_email->closeCursor();
echo $_POST['user'];

      $sql->execute(array(
        $_POST['user'],
        hash('sha256', $_POST['pwd']),
        $_POST['email'],
        $key,
        0
      ));

//      $sql->closeCursor();

      $verify->execute(array(
        $_POST['user'] ,
        hash('sha256', $_POST['pwd']),
        $_POST['email'],
        $key
      ));

      $data = $verify->fetch();

      if ($data[0] == 1)
      {
        $header="MIME-Version: 1.0\r\n";
        $header.='From:"PrimFX.com"<support@primfx.com>'."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';
        $message='
                 <html>
                    <body>
                       <div align="center">
                          <a href="http://camagru/confirmation.php?pseudo='.urlencode($_POST['user']).'&key='.$key.'">Confirmez votre compte !</a>
                       </div>
                    </body>
                 </html>
                     ';
        mail($_POST['email'], "Confirmation de compte", $message, $header);
        session_start();
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['email'] = $_POST['email'];

        header('Location: membre.php');
        exit();
      }
      else
      {
        header('location: membre.php?error=write');
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
