<?php
  session_start();
  $nick =  empty($_POST['nick']) ? '' : $_POST['nick'] ;
  $email =  empty($_POST['email']) ? '' : $_POST['email'] ;
  $tresc =  empty($_POST['tresc']) ? '' : $_POST['tresc'] ;

  echo $nick, '  ';
  echo $email, '  ';
  echo $tresc, '  ';
?>