<?php
  session_start();
  
  if(isset($_POST['email']) && isset($_POST['description'])){
    $email = $_POST['email'];
    $description = $_POST['description'];
    $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
    $sql = "INSERT INTO `messages`(`email`, `description`) VALUES ('".$email."','".$description."')";
    $conn->query($sql);
    header("Location: http://localhost/Strona/index.php?postsPage=0");
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
  <title>Formularz kontaktowy</title>
</head>
<body>
  <main>
    <div class="wrapper">
      <form action="./contact.php" method="POST">
        <div class="input-label">
          <label for="email">Email:</label>
          <input name="email" type="email" placeholder="Twój email" required>
        </div>
        <div class="input-label">
          <label for="description">Pytanie:</label>
          <textarea name="description" id="" cols="30" rows="10" placeholder="Wpisz swój tekst" required></textarea>
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