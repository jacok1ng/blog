<?php
  session_start();

  // Create connection
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  $nick =  empty($_POST['nick']) ? '' : $_POST['nick'] ;
  $password =  empty($_POST['password']) ? '' : $_POST['password'] ;
  $sql = "SELECT password, userid, roleid FROM user WHERE Username='$nick'";
  $result = $conn->query($sql);
  $fetched = mysqli_fetch_row($result);
  
  if(password_verify($password, $fetched[0])){
    $_SESSION['logged'] = true;
    $_SESSION['nickname'] = $nick;
    $_SESSION['id'] = $fetched[1];
    $_SESSION['roleId'] = $fetched[2];
    header("Location: http://localhost/Strona/index.php?postsPage=0");
  }
  else{
    echo 'Nie udało się';
    $_SESSION['logged'] = false;
  }
?>