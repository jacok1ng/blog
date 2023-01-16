<?php
  session_start();
  unset($_SESSION['logged']);
  unset($_SESSION['nickname']);
  unset($_SESSION['id']);
  header("Location: http://localhost/Strona/index.php?postsPage=0");
?>