<?php
  session_start();
  $nick =  empty($_POST['nick']) ? '' : $_POST['nick'] ;
  $email =  empty($_POST['email']) ? '' : $_POST['email'] ;
  $password =  empty($_POST['password']) ? '' : $_POST['password'] ;
  $captcha =  empty($_POST['captcha-input']) ? '' : $_POST['captcha-input'] ;

  if($_SESSION['captcha-value'] + 1 == $captcha){
    echo 'Captcha sie zgadza!';
    echo $email, '  ';
    echo $password, '  ';
    echo $captcha, '  ';
  }
  else{
    echo 'Niepoprawna captcha!';
  }
?>