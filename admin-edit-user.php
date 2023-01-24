<?php
  session_start();
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");

  if(isset($_GET['userId'])){
    $_SESSION['userId'] = $_GET['userId'];
  }

  if(isset($_POST['nick']) && isset($_POST['roleId']) && isset($_POST['email'])){
    $nick = $_POST['nick'];
    $roleId = $_POST['roleId'];
    $email = $_POST['email'];
    $sql = "UPDATE user SET Username='".$nick."', Email='".$email."', roleId='".$roleId."' WHERE UserID='".$_SESSION['userId']."'";
    $conn->query($sql);
    header("Location: http://localhost/Strona/admin-panel.php");
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/admin-panel.css" />
  <link rel="icon" href="assets/logo-white.png" />
  <title>Wszystkie komentarze</title>
</head>
<body>
  <main>
    <div class="wrapper">
      <form class="form-style" action="admin-edit-user.php" method="POST">
        <?php
          $sql = "SELECT Username, RoleID, Email FROM user WHERE UserID='".$_SESSION['userId']."'";
          $result = $conn->query($sql);
          $fetched = mysqli_fetch_row($result);
        ?>
        <div class="input-wrapper">
          <label for="nick">Nick:</label>
          <?php
            echo '<input name="nick" type="text" value="'.$fetched[0].'" required>';
          ?>
        </div>
        <div class="input-wrapper">
          <label for="nick">RoleId:</label>
          <?php
            echo '<input name="roleId" type="number" value="'.$fetched[1].'" required>';
          ?>
        </div>
        <div class="input-wrapper">
          <label for="Email">Email:</label>
          <?php
            echo '<input name="email" type="email" value="'.$fetched[2].'" required>';
          ?>
        </div>
        <div class="actions">
          <button class="styled-button" type="submit">Edytuj</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>