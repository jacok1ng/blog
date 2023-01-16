<?php
  session_start();

  // Create connection
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  $nick =  empty($_POST['nick']) ? '' : $_POST['nick'] ;
  $email =  empty($_POST['email']) ? '' : $_POST['email'] ;
  $password =  empty($_POST['password']) ? '' : $_POST['password'] ;
  $captcha =  empty($_POST['captcha-input']) ? '' : $_POST['captcha-input'] ;

  if($_SESSION['captcha-value'] + 1 == $captcha){
    echo 'Captcha sie zgadza!';
    echo $email, '  ';
    echo $password, '  ';
    echo $captcha, '  ';
    $sql = "INSERT INTO `user`(`RoleID`, `Username`, `Password`, `Email`) VALUES (1, '{$nick}','".password_hash($password, PASSWORD_DEFAULT)."','{$email}')";
    $conn->query($sql);
    header("Location: http://localhost/Strona/index.php?postsPage=0");
  }
  else{
    echo 'Niepoprawna captcha!';
  }
?>