<?php
  session_start();
  $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
  $savedText = "";
  $title = "";
  $edit = isset($_GET['edit']) ? $_GET['edit'] : false;

  if($edit){
    $postId = $_GET['postId'];
    $sql = "SELECT Title, Content FROM posts WHERE PostID='{$postId}'";
    $result = $conn->query($sql);
    $fetched = mysqli_fetch_row($result);
    $_SESSION["formatText"] = $fetched[1];
    $_SESSION["title"] = $fetched[0];
    $_SESSION['edit'] = true;
    $_SESSION['postId'] = $postId;
  }

  if(isset($_POST["wstecz"])){
    unset($_SESSION["podglad"]);
    unset( $_SESSION["tresc"]);
    // unset( $_SESSION["title"]);
    if(isset($_SESSION["formatText"])){
      $savedText = $_SESSION["formatText"];
      $title = $_SESSION["title"];
    }
  }

  if(isset($_POST["submit"]) || isset($_POST["podglad"])){
    $_SESSION["tresc"] = $_POST["tresc"];
    $_SESSION["title"] = $_POST["title"];
  }
  
  function transformText($text){
    $preview = preg_replace("#\[b\](.+)\[/b\]#", "<strong>$1</strong>", $text);
    $preview = preg_replace("#\[i\](.+)\[/i\]#", "<em>$1</em>", $preview);
    $preview = preg_replace("#\[u\](.+)\[/u\]#", "<u>$1</u>", $preview);
    $preview = preg_replace("#\[url\](.+)\[/url\]#", "<a href='$1'>$1</a>", $preview);
    return $preview;
  }

  function showPreview(){
    $conn = new mysqli("localhost", "admin", "qwerty123", "blog");
    if(isset($_POST["tresc"]) && empty($_POST["submit"])){
      echo '<strong>Podgląd:</strong><br />';
      echo transformText($_POST["tresc"]);
      $_SESSION["formatText"] = $_POST["tresc"];
      $_SESSION["title"] = $_POST["title"];
    }
    else if(isset($_POST["tresc"]) && isset($_POST["submit"])){
      $shouldEdit = isset($_SESSION["edit"]) ? $_SESSION["edit"] : false;
      echo '<strong>Wysłano posta:</strong><br /><br />';
      echo $_POST["title"]."<br />";
      echo transformText($_POST["tresc"]);
      echo '<div class="actions">';
      echo '<a href="./index.php">Wróć do strony głównej</a>';
      echo '</div>';
      if($shouldEdit){
        $sql = "UPDATE posts SET Title='".$_POST["title"]."', Content='".$_POST["tresc"]."' WHERE PostID='".$_SESSION['postId']."'";
        $conn->query($sql);
        
      }else{
        $sql = "INSERT INTO `posts`(`UserID`, `CategoryID`, `Title`, `Content`) VALUES (".$_SESSION['id'].",1,'".$_POST["title"]."','".$_POST["tresc"]."')";
        $conn->query($sql);
      }
      header("Location: http://localhost/Strona/index.php?postsPage=0");
      unset( $_SESSION["title"]);
    }
    else{
      $defaultValue = isset($_SESSION["title"]) ? $_SESSION["title"] : "";
      echo '<div class="input-label">';
      echo '<label for="title">Tytuł:</label>';
      echo '<input name="title" placeholder="Tytuł" value="'.$defaultValue.'" required/>';
      echo '<label for="tresc">Tresc:</label>';
      echo '<textarea name="tresc" label="Tresc" placeholder="Wpisz tutaj treść posta" required>',isset($_SESSION["formatText"]) ? $_SESSION["formatText"] : "",'</textarea>';
      echo '</div>';
    }
  }

  function showButtons(){
    if(empty($_POST["podglad"]) && empty($_POST["submit"])){
      echo '<button type="submit" name="podglad" value="podglad" class="styled-button">Podgląd</button>';
      echo '<button type="submit" name="submit" value="submit" class="styled-button">Wyslij</button>';
    }
    else if(isset($_POST["podglad"])){
      echo '<button type="wstecz" name="wstecz" value="wstecz" class="styled-button">Wstecz</button>';
    }
  }

  function showGuide(){
    if(empty($_POST['submit'])){
      echo '<div class="info-box">';
      echo '<p>Możesz korzystać z takich znaczników jak:</p><br />';
      echo '<p>[b] - <b>pogrubienie</b></p>';
      echo '<p>[i] - <i>kursywa</i></p>';
      echo '<p>[u] - <u>podkreślenie</u></p>';
      echo '<p>[url] - <a href="#">link</a></p><br />';
      echo '</div>';
    }
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/add-post.css" />
  <link rel="icon" href="assets/logo-white.png" />
  <title>Dodawanie posta</title>
</head>
<body>
  <main>
    <div class="wrapper">
      <form action="./add-post.php" method="POST">
        <?php
          showGuide();
          showPreview();
        ?>
        <div class="actions">
          <?php
            showButtons();
          ?>
        </div>
      </form>
    </div>
  </main>
</body>
</html>