<?php
  session_start();
  require 'utils.php';

  // === DATABASE ===
  $servername = "localhost";
  $username = "admin";
  $password = "qwerty123";
  $dbname = "blog";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $_SESSION['conn'] = $conn;
  //=================

  $_SESSION["CARD_STATUS"] = "INIT";
  unset($_SESSION["formatText"]);
  unset($_SESSION['edit']);
  $MAX_DISPLAYED_POSTS = 4;
  $postsPage = 0;

  $isLogged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
  $userRole = isset($_SESSION['roleId']) ? $_SESSION['roleId'] : 0;
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" href="assets/logo-white.png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="./app.js" defer></script>
    <title>Eryk Dąbek Blog</title>
  </head>
  <body>
    <div class="backdrop">
      <div class="modal">
        <div id="comment-form">
          <form  action="comment.php"  method="post">
            <div class="input-label">
              <label for="nick">Nick:</label>
              <input name="nick" type="text" label="Nick"/>
            </div>
            <div class="input-label">
              <label for="email">Email:</label>
              <input name="email" type="email" label="Email"/>
            </div>
            <div class="input-label">
              <label for="tresc">Tresc:</label>
              <textarea name="tresc" label="Tresc"></textarea>
            </div>
            <button class="styled-button margin-top-20" type="submit">Wyslij</button>
            <button class="styled-button close-btn margin-top-10">Zamknij</button>
          </form>
        </div>
        <!-- register -->
        <div id="register-form">
          <form id="register-formula" action="register.php" method="post">
            <div class="input-label">
              <label for="nick">Nick:</label>
              <input id="reg-nick" name="nick" type="text" label="Nick"/>
            </div>
            <div class="input-label">
              <label for="email">Email:</label>
              <input id="reg-email" name="email" type="email" label="Email"/>
            </div>
            <div class="input-label">
              <label for="password">Haslo:</label>
              <input id="reg-password" name="password" type="password" label="password"/>
            </div>
            <div id="captcha-wrapper">
              <div class="captcha-element">
                <?php
                  $random = rand(0, 8);
                  $array = array();

                  for($i = 0; $i < 9; $i++){
                    if($i == $random)
                      array_push($array, '<img src="./assets/red.png" class="captcha-image" alt="red"/>');
                    else
                      array_push($array, '<img src="./assets/blue.png" class="captcha-image" alt="blue"/>');
                  }

                  $_SESSION['captcha-value'] = $random;
                  for($i = 0; $i < 9; $i++)
                      echo $array[$i];
                  
                ?>
              </div>
            </div>
            <div class="input-label margin-top-20">
              <label for="captcha-input">Podaj numer kratki z czerwonym kwadratem:</label>
              <input name="captcha-input" type="text" label="captcha-input"/>
            </div>
            <button id="register-btn" class="styled-button margin-top-20" type="submit">Wyslij</button>
            <button class="styled-button close-btn margin-top-10">Zamknij</button>
          </form>
        </div>
        <!--  -->
        <!-- login -->
        <div id="login-form">
          <form id="login-formula" action="login.php" method="post">
            <div class="input-label">
              <label for="nick">Nick:</label>
              <input id="login-nick" name="nick" type="text" label="Nick"/>
            </div>
            <div class="input-label">
              <label for="password">Haslo:</label>
              <input id="login-password" name="password" type="password" label="password"/>
            </div>
            <button id="login-btn" class="styled-button margin-top-20" type="submit">Wyslij</button>
            <button class="styled-button close-btn margin-top-10">Zamknij</button>
          </form>
        </div>
        <!--  -->
      </div>
    </div>
    <header>
      <div class="header-content">
        <img class="header-logo" src="assets/logo-white.png" />
        <p>Programowanie na Froncie</p>
      </div>
    </header>
    <main>
      <nav class="rounded-corners">
        <?php
          if($isLogged){
            echo '<div class="user-info">';
            echo '<img src="./assets/avatar.png" alt="avatar" width="40" height="40">';
            echo '<div>';
            echo '<p><strong>'.$_SESSION['nickname'].' (ID:'.$_SESSION['id'].')</strong></p>';
            echo '<a href="./logout.php" class="red-font small-text">Wyloguj</a>';
            echo '</div>';
            echo '</div>';
          }
        ?>
        <ul class="navigation-list">
          <li><a href="#">Strona główna</a></li>
          <li><a href="#">JavaScript</a></li>
          <li><a href="#">React</a></li>
          <li><a href="#">CSS</a></li>
          <li><a href="./contact.php">Formularz kontaktowy</a></li>
          <li id="register" class="clickable">Rejestracja</li>
          <?php
            if($isLogged && $userRole == 2)
              echo '<li><a href="./admin-panel.php"><span class="red-font">Panel administratora</span></a></li>';
          ?>
          <?php
            if(!$isLogged)
            echo '<li id="login" class="clickable">Logowanie</li>';
          ?>
          <li><a href="./cards.php"><strong>Gra w oczko 🃏</strong></a></li>
          <?php
            if($isLogged)
              echo '<li><a href="./add-post.php">Dodaj post</a></li>';
          ?>
        </ul>
      </nav>
      <div class="content rounded-corners">
        <div class="greetings">
          <h2>Witaj na blogu</h2>
          <h1>Programowanie na Froncie! ❤</h1>
        </div>
        <div class="main-posts">
          <?php
            $sql = "SELECT * FROM posts";
            $result = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
            $mysqlCounter = count($result) > $MAX_DISPLAYED_POSTS ? $MAX_DISPLAYED_POSTS : count($result);
            $offset = (isset($_GET['postsPage']) && is_numeric($_GET['postsPage'])) ? ($_GET['postsPage'] * $MAX_DISPLAYED_POSTS) : 0;
            
            for($i = 0; $i < $mysqlCounter; $i++){
              if(($i + $offset) > (count($result) - 1)) break;
              echo '<div class="main-post">';
              echo '<img src="./assets/post.png" alt="">';
              echo '<div class="main-post-info">';
              echo '<div class="main-post-title">', $result[$i + $offset]['Title'], '</div>';
              echo '<div class="main-post-desc">', transformText($result[$i + $offset]['Content']), '</div>';
              echo '<div class="additional-actions">';
              echo '<a href="./add-comment.php?postId='.$result[$i + $offset]['PostID'].'"><span class="clickable">Dodaj komentarz</span></a>';
              echo '<a href="./all-comments.php?postId='.$result[$i + $offset]['PostID'].'"><span class="clickable">Wyswietl komentarze</span></a>';
              if($isLogged){
                // echo '<div class="add-comment clickable">Dodaj komentarz</div>';
                //RoleId 2 == ADMIN
                if($result[$i + $offset]['UserID'] == $_SESSION['id'] || $_SESSION['roleId'] == 2){
                  echo '<a href="./delete-post.php?postId='.$result[$i + $offset]['PostID'].'"><span class="clickable">Usun</span></a>';
                  echo '<a href="./add-post.php?postId='.$result[$i + $offset]['PostID'].'&edit=true"><span class="clickable">Edytuj</span></a>';
                }
              }
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
            
            $pages = ceil(count($result) / $MAX_DISPLAYED_POSTS);
            if($pages > 1){
              echo '<ul class="pagination">';
              echo '>> ';
              for($i = 0; $i < $pages; $i++){
                echo '<li><a href="?postsPage=', $i,'">', $i + 1, '</a></li>';
              }
              echo ' <<';
              echo '</ul>';
            }
          ?>
        </div>
      </div>
      <div class="last-posts rounded-corners">
        <h3>Ostatnie posty</h3>
        <div class="posts">
          <?php
            $counter = count($result) > $MAX_DISPLAYED_POSTS ? $MAX_DISPLAYED_POSTS : count($result);
            for($i = 0; $i < $counter; $i++){
              echo '<div class="post rounded-corners">';
              echo '<div class="post-thumbnail">';
              echo '<img src="assets/example_thumbnail.jpg" alt="" />';
              echo '</div>';
              echo '<div class="post-description">',$result[$i]['Content'],'</div>';
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </main>
    <footer>Wykonał Eryk Dąbek &copy; 2022</footer>
  </body>
</html>
