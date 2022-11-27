<?php
  session_start();
  $cards = array();
  $krupierWynik = 0;
  $graczWynik = 0;
  $krupierKarty = array();
  $graczKarty = array();
  $nextCard = 4;

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
      if($j == 11) $index = "J";
      if($j == 12) $index = "Q";
      if($j == 13) $index = "K";
      if($j == 14) $index = "A";

      array_push($cards, $type.$index.".png");
    } 
  }
  shuffle($cards);

  
  array_push($krupierKarty, $cards[0]);
  array_push($krupierKarty, $cards[2]);

  array_push($graczKarty, $cards[1]);
  array_push($graczKarty, $cards[3]);
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
              for($i = 0; $i < count($krupierKarty); $i++){
                echo "<img src='./assets/cards/", $krupierKarty[$i], "' alt='card' class='card'>";
              }
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
              for($i = 0; $i < count($graczKarty); $i++){
                echo "<img src='./assets/cards/", $graczKarty[$i], "' alt='card' class='card'>";
              }
            ?>
            <!-- <img src="./assets/cards/karo10.png" alt="card" class="card">
            <img src="./assets/cards/karo10.png" alt="card" class="card">
            <img src="./assets/cards/karo10.png" alt="card" class="card"> -->
          </div>
        </div>
        <div class="buttons">
          <button class="styled-button">Następna karta</button>
          <button class="styled-button">Stop</button>
        </div>
      </div>
    </main>
  </body>
</html>