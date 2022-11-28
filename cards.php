<?php
  session_start();
  $cards = array();
  $krupierWynik = 0;
  $graczWynik = 0;
  $krupierKarty = array();
  $graczKarty = array();
  $nextCard = 4;

  // 1 - init
  // 2- gracz dobiera
  // 3 - krupier dobiera
  // 4 - idle

  for ($i = 0; $i < 4; $i++) {
    for ($j = 2; $j <= 14; $j++) {
      $type = "";
      $index = 0;

      switch($i){
        case 0:{
          $type = "karo";
          break;
        }
        case 1:{
          $type = "kier";
          break;
        }
        case 2:{
          $type = "pik";
          break;
        }
        case 3:{
          $type = "trefl";
          break;
        }
      }

      $index = $j;
      $score = $j;
      if($j == 11) {
        $index = "J";
        $score = 2;
      }
      if($j == 12) {
        $index = "Q";
        $score = 3;
      }
      if($j == 13) {
        $index = "K";
        $score = 4;
      }
      if($j == 14) {
        $index = "A";
        $score = 11;
      }

      array_push($cards, [$type.$index.".png", $score]);
    } 
  }
  shuffle($cards);
  $state = isset($_GET['state']) ? $_GET['state'] : $_SESSION['CARD_STATUS'];
  if($state != "INIT" && $state != '1') {
    $cards = $_SESSION["CARDS"];
    $nextCard = $_SESSION["NASTEPNA_KARTA"];
    $krupierWynik = empty($_SESSION["KRUPIER_WYNIK"]) ? 0 : $_SESSION["KRUPIER_WYNIK"];
    $graczWynik = empty($_SESSION["GRACZ_WYNIK"]) ? 0 : $_SESSION["GRACZ_WYNIK"];
    $krupierKarty = $_SESSION["KRUPIER_KARTY"];
    $graczKarty = $_SESSION["GRACZ_KARTY"];
    if($state == '2'){
      array_push($graczKarty, $cards[$nextCard]);
      $graczWynik += $cards[$nextCard][1];
      $_SESSION["NASTEPNA_KARTA"] = $nextCard + 1;
      $_SESSION['GRACZ_KARTY'] = $graczKarty;
      $_SESSION['GRACZ_WYNIK'] = $graczWynik;
    }
    else if($state == '3'){
      for($i = 0; $i < 10; $i++){
        if($krupierWynik < 16){
          array_push($krupierKarty, $cards[$nextCard]);
          $krupierWynik += $cards[$nextCard][1];
          $_SESSION["NASTEPNA_KARTA"] = $nextCard + 1;
          $_SESSION['KRUPIER_KARTY'] = $krupierKarty;
          $_SESSION['KRUPIER_WYNIK'] = $krupierWynik;
          $nextCard++;
        }
        else
          break;
      }
    }
  }
  else {
    array_push($krupierKarty, $cards[0]);
    array_push($krupierKarty, $cards[2]);
    $krupierWynik = $cards[0][1] + $cards[2][1];

    array_push($graczKarty, $cards[1]);
    array_push($graczKarty, $cards[3]);
    $graczWynik = $cards[1][1] + $cards[3][1];

    $_SESSION["CARDS"] = $cards;
    $_SESSION["CARD_STATUS"] = "IDLE";
    $_SESSION["NASTEPNA_KARTA"] = $nextCard;
    $_SESSION["GRACZ_WYNIK"] = $graczWynik;
    $_SESSION["GRACZ_KARTY"] = $graczKarty;
    $_SESSION["KRUPIER_WYNIK"] = $krupierWynik;
    $_SESSION["KRUPIER_KARTY"] = $krupierKarty;
  }

  function displayButtons(){
    $stage = isset($_GET['state']) ? $_GET['state'] : $_SESSION['CARD_STATUS'];
    if($_SESSION["GRACZ_WYNIK"] > 21){
      echo '<div class="lose info-box">';
      echo '<p>Przegrałeś! Spróbuj ponownie!</p>';
      echo '</div>';
    }
    else{
      if($stage == '3'){
        if($_SESSION["KRUPIER_WYNIK"] > 21){
          echo '<div class="win info-box">';
          echo '<p>Wygrałeś! Gratulacje!</p>';
          echo '</div>';
        }
        else if($_SESSION["KRUPIER_WYNIK"] == $_SESSION["GRACZ_WYNIK"]){
          echo '<div class="draw info-box">';
          echo '<p>Remis!</p>';
          echo '</div>';
        }
        else if($_SESSION["KRUPIER_WYNIK"] <= 21 && ($_SESSION["KRUPIER_WYNIK"] > $_SESSION["GRACZ_WYNIK"]))
        {
          echo '<div class="lose info-box">';
          echo '<p>Przegrałeś! Spróbuj ponownie!</p>';
          echo '</div>';
        }
        else{
          echo '<div class="win info-box">';
          echo '<p>Wygrałeś! Gratulacje!</p>';
          echo '</div>';
        }
      }
      else{
        echo '<a href="./cards.php?state=2"><button class="styled-button">Następna karta</button></a>';
        echo '<a href="./cards.php?state=3"><button class="styled-button">Stop</button></a>';
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="card.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <title>Card game</title>
  </head>
  <body>
    <main>
      <h1>Gra w oczko</h1>
      <div class="board">
        <div class="krupier player--on--board">
          <div class="score">
            <h3>Krupier:</h3>
            <h4>Wynik: <?php echo $krupierWynik; ?></h4>
          </div>
          <div class="cards">
            <?php
              for($i = 0; $i < count($krupierKarty); $i++)
                echo "<img src='./assets/cards/", $krupierKarty[$i][0], "' alt='card' class='card'>";
            ?>
          </div>
        </div>
        <div class="gracz player--on--board">
          <div class="score">
            <h3>Ty:</h3>
            <h4>Wynik: <?php echo $graczWynik; ?></h4>
          </div>
          <div class="cards">
            <?php
              for($i = 0; $i < count($graczKarty); $i++)
                echo "<img src='./assets/cards/", $graczKarty[$i][0], "' alt='card' class='card'>";
            ?>
          </div>
        </div>
        <div class="buttons">
          <a href="./cards.php?state=1"><button class="styled-button">Restart</button></a>
          <!-- <a href="./cards.php?state=2"><button class="styled-button">Następna karta</button></a>
          <a href="./cards.php?state=3"><button class="styled-button">Stop</button></a> -->
          <!-- <div class="lose">
            <p>Przegrałeś! Spróbuj ponownie!</p>
          </div> -->
          <?php
            displayButtons();
          ?>
        </div>
      </div>
    </main>
  </body>
</html>