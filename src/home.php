<!doctype html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
  </head>

  <body>
    <header>
      <h1><a href="index.php"><i class="fas fa-bed"></i> Super Legit Reddit</a></h1>
      <nav>
        <ul>
          <li>username</li>
          <li><a href="action_logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <section id="stories">

      <article class="story">
        <header><h2>Porto won!</h2></header>
        <p>Thank you Eder.</p>
        <form action="action_add_comment.php" method="post">
          <input type="hidden" value="1">
          <input type="textarea" placeholder="Add comment">
        </form>
      </article>

      <article class="story">
        <header><h2>Daredevil S3 is out!</h2></header>
        <p>Go check it out!</p>
        <form action="action_add_comment.php" method="post">
          <input type="hidden" value="2">
          <input type="text" placeholder="Add comment">
        </form>
      </article>

      <article class="new-story">
        <form action="action_add_story.php" method="post">
          <input type="text" placeholder="Add story">
        </form>
      </article>

    </section>

  </body>
</html>