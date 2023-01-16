<?php
  function displayButtons(){
    $stage = isset($_GET['state']) ? $_GET['state'] : $_SESSION['CARD_STATUS'];
    if($_SESSION["GRACZ_WYNIK"] > 21){
      showInfoBox('lose');
    }
    else{
      if($stage == '3'){
        if($_SESSION["KRUPIER_WYNIK"] > 21){
          showInfoBox('win');
        }
        else if($_SESSION["KRUPIER_WYNIK"] == $_SESSION["GRACZ_WYNIK"]){
          showInfoBox('draw');
        }
        else if($_SESSION["KRUPIER_WYNIK"] <= 21 && ($_SESSION["KRUPIER_WYNIK"] > $_SESSION["GRACZ_WYNIK"]))
        {
          showInfoBox('lose');
        }
        else{
          showInfoBox('win');
        }
      }
      else{
        echo '<a href="./cards.php?state=2"><button class="styled-button">Następna karta</button></a>';
        echo '<a href="./cards.php?state=3"><button class="styled-button">Stop</button></a>';
      }
    }
  }

  function showInfoBox($type){
    switch($type){
      case 'draw':{
        echo '<div class="draw info-box">';
        echo '<p>Remis!</p>';
        echo '</div>';
        break;
      }
      case 'win':{
        echo '<div class="win info-box">';
        echo '<p>Wygrałeś! Gratulacje!</p>';
        echo '</div>';
        break;
      }
      case 'lose':{
        echo '<div class="lose info-box">';
        echo '<p>Przegrałeś! Spróbuj ponownie!</p>';
        echo '</div>';
        break;
      }
      default: {
        echo '<div class="lose info-box">';
        echo '<p>Przegrałeś! Spróbuj ponownie!</p>';
        echo '</div>';
        break;
      }
    }
  }
?>