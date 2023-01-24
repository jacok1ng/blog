<?php
  session_start();
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  $isLogged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;

  if(isset($_GET['postId'])){
    $_SESSION['postId'] = $_GET['postId'];
  }
  
  if(isset($_POST['comment'])){
    $postId = $_SESSION['postId'];
    $comment = $_POST['comment'];
    if($isLogged){
      $userId = $_SESSION['id'];
      $sql = "INSERT INTO `comments`(`PostID`, `Content`, `UserID`) VALUES ('".$postId."','".$comment."', '".$userId."')";
      $conn->query($sql);
    }
    else{
      $sql = "INSERT INTO `comments`(`PostID`, `Content`) VALUES ('".$postId."','".$comment."')";
      $conn->query($sql);
    }
    unset($_SESSION['postId']);
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/contact.css" />
  <link rel="icon" href="assets/logo-white.png" />
  <title>Dodawanie komentarza</title>
</head>
<body>
  <main>
    <div class="wrapper">
      <form action="./add-comment.php" method="POST">
        <div class="input-label">
          <label for="comment">Komentarz:</label>
          <textarea name="comment" id="" cols="30" rows="10" placeholder="Wpisz swój tekst" required></textarea>
        </div>
        
        <div class="actions">
          <button class="styled-button">Wyślij</button>
        </div>
        </div>
      </form>
    </div>
  </main>
</body>
</html>