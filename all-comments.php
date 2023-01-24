<?php
  session_start();
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  
  if(isset($_GET['postId'])){
    $_SESSION['postId'] = $_GET['postId'];
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/all-comments.css" />
  <link rel="icon" href="assets/logo-white.png" />
  <title>Wszystkie komentarze</title>
</head>
<body>
  <main>
    <div class="wrapper">
      <?php
        $sql = "SELECT * FROM comments WHERE PostID='".$_SESSION['postId']."'";
        $result = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        if(count($result) > 0){
          for($i = 0; $i < count($result); $i++){
            $author = 'Anonymous'; 
            if(isset($result[$i]['UserID'])){
              $sql = "SELECT `Username` FROM user WHERE UserID='".$result[$i]['UserID']."'";
              $authorResult = $conn->query($sql);
              $fetched = mysqli_fetch_row($authorResult);
              $author = $fetched[0];
            }
            echo '<div class="comment-li">';
            echo '<div class="author">'.$author.'</div>';
            echo '<div class="description">'.$result[$i]['Content'].'</div>';
            echo '</div>';
          }
        }
        else{
          echo '<div class="comment-li">';
          echo '<div class="no-comments"><h3>Brak komentarzy dotyczących tego posta</h3></div>';
          echo '</div>';
        }
      ?>
    </div>
  </main>
</body>
</html>