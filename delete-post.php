<?php
  session_start();
  $postId = $_GET['postId'];
  echo 'ID POSTA: '.$_GET['postId'];
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  $sql = "DELETE FROM posts WHERE PostID='$postId'";
  $conn->query($sql);
  header("Location: http://localhost/Strona/index.php?postsPage=0");
?>