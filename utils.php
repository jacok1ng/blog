<?php
   function transformText($text){
    $preview = preg_replace("#\[b\](.+)\[/b\]#", "<strong>$1</strong>", $text);
    $preview = preg_replace("#\[i\](.+)\[/i\]#", "<em>$1</em>", $preview);
    $preview = preg_replace("#\[u\](.+)\[/u\]#", "<u>$1</u>", $preview);
    $preview = preg_replace("#\[url\](.+)\[/url\]#", "<a href='$1'>$1</a>", $preview);
    return $preview;
  }
?>