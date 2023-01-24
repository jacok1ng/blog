<?php
  session_start();
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  
  if(isset($_GET['editUser'])){
    $editUser = $_GET['editUser'];
    header("Location: http://localhost/Strona/admin-edit-user.php?userId=".$editUser."");
  }
  if(isset($_GET['deleteUser'])){
    $_SESSION['deleteUser'] = $_GET['deleteUser'];
    $deleteUser = $_SESSION['deleteUser'];
    $sql = "DELETE FROM user WHERE UserID='$deleteUser'";
    $conn->query($sql);
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
      <?php
        $sql = "SELECT * FROM user";
        $result = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        if(count($result) > 0){
          for($i = 0; $i < count($result); $i++){
            echo '<div class="user-li">';
            echo '<div class="nick">';
            echo '<span><strong>'.$result[$i]['Username'].'</strong></span>';
            echo '</div>';
            echo '<div class="actions">';
            echo '<a href="./admin-panel.php?editUser='.$result[$i]['UserID'].'"><button class="styled-button">Edytuj</button></a>';
            echo '<a href="./admin-panel.php?deleteUser='.$result[$i]['UserID'].'"><button class="styled-button">Usun</button></a>';
            echo '</div>';
            echo '</div>';
          }
        }
      ?>
      <!-- <div class="user-li">
        <div class="nick">
          <span><strong>Jaca</strong></span>
        </div>
        <div class="actions">
            <a href="./admin-panel.php?deleteUser=3"><button class="styled-button">Usun</button></a>
            <a href="./admin-panel.php?editUser=3"><button class="styled-button">Edytuj</button></a>
        </div>
      </div> -->

    </div>
  </main>
</body>
</html>