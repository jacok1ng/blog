<?php
  session_start();
  $savedText = "";

  if(isset($_POST["wstecz"])){
    unset($_SESSION["podglad"]);
    unset( $_SESSION["tresc"]);
    if(isset($_SESSION["formatText"])){
      $savedText = $_SESSION["formatText"];
    }
  }

  if(isset($_POST["submit"]) || isset($_POST["podglad"])){
    $_SESSION["tresc"] = $_POST["tresc"];
  }
  
  function transformText($text){
    $preview = preg_replace("#\[b\](.+)\[/b\]#", "<strong>$1</strong>", $text);
    $preview = preg_replace("#\[i\](.+)\[/i\]#", "<em>$1</em>", $preview);
    $preview = preg_replace("#\[u\](.+)\[/u\]#", "<u>$1</u>", $preview);
    $preview = preg_replace("#\[url\](.+)\[/url\]#", "<a href='$1'>$1</a>", $preview);
    return $preview;
  }

  function showPreview(){
    if(isset($_POST["tresc"]) && empty($_POST["submit"])){
      echo '<strong>Podgląd:</strong><br />';
      echo transformText($_POST["tresc"]);
      $_SESSION["formatText"] = $_POST["tresc"];
    }
    else if(isset($_POST["tresc"]) && isset($_POST["submit"])){
      echo '<strong>Wysłano posta:</strong><br /><br />';
      echo transformText($_POST["tresc"]);
      echo '<div class="actions">';
      echo '<a href="./index.php">Wróć do strony głównej</a>';
      echo '</div>';
    }
    else{
      echo '<div class="input-label">';
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