<?php
  $MAX_DISPLAYED_POSTS = 5;
  $postsPage = 0;

  class Post{
    public string $title;
    public string $description;
    public $comments = null;

    function __construct(string $title, string $description){
      $this->title = $title;
      $this->description = $description;
    }
  }

  $posts = [
    new Post("Example title 1", "1 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 2", "2 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 3", "3 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 4", "4 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 5", "5 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 6", "6 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 7", "7 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
    new Post("Example title 8", "8 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi libero neque recusandae in nesciunt? Sit accusantium labore ad nam praesentium."),
  ];
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" href="assets/logo-white.png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <title>Eryk Dąbek Blog</title>
  </head>
  <body>
    <header>
      <div class="header-content">
        <img class="header-logo" src="assets/logo-white.png" />
        <p>Programowanie na Froncie</p>
      </div>
    </header>
    <main>
      <nav class="rounded-corners">
        <ul class="navigation-list">
          <li><a href="#">Strona główna</a></li>
          <li><a href="#">JavaScript</a></li>
          <li><a href="#">React</a></li>
          <li><a href="#">CSS</a></li>
        </ul>
      </nav>
      <div class="content rounded-corners">
        <div class="greetings">
          <h2>Witaj na blogu</h2>
          <h1>Programowanie na Froncie! ❤</h1>
        </div>
        <div class="main-posts">
          <?php
            $pages = ceil(count($posts) / $MAX_DISPLAYED_POSTS);
            $counter = count($posts) > $MAX_DISPLAYED_POSTS ? $MAX_DISPLAYED_POSTS : count($posts);
            $postsOffset = (isset($_GET['postsPage']) && is_numeric($_GET['postsPage'])) ? ($_GET['postsPage'] * $MAX_DISPLAYED_POSTS) : 0;

            for($i = 0; $i < $counter; $i++){
              if(($i + $postsOffset) > (count($posts) - 1)) break;
              echo '<div class="main-post">';
              echo '<img src="./assets/post.png" alt="">';
              echo '<div class="main-post-info">';
              echo '<div class="main-post-title">', $posts[$i + $postsOffset]->title, '</div>';
              echo '<div class="main-post-desc">', $posts[$i + $postsOffset]->description, '</div>';
              echo '</div>';
              echo '</div>';
            }

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

          <div class="main-post">
          <img src="./assets/post.png" alt="">
          <div class="main-post-info">
          <div class="main-post-title">Title</div>
          <div class="main-post-desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non, reprehenderit?</div>
          </div>
          </div>
          
        </div>
      </div>
      <div class="last-posts rounded-corners">
        <h3>Ostatnie posty</h3>
        <div class="posts">
          <?php
            $counter = count($posts) > $MAX_DISPLAYED_POSTS ? $MAX_DISPLAYED_POSTS : count($posts);
            for($i = 0; $i < $counter; $i++){
              echo '<div class="post rounded-corners">';
              echo '<div class="post-thumbnail">';
              echo '<img src="assets/example_thumbnail.jpg" alt="" />';
              echo '</div>';
              echo '<div class="post-description">',$posts[$i]->description,'</div>';
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </main>
    <footer>Wykonał Eryk Dąbek &copy; 2022</footer>
  </body>
</html>