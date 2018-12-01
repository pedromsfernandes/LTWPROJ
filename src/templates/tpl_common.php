<?php

include_once('../database/db_user.php');

function draw_header($username)
{
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
            <script src="../scripts/script.js" defer></script>
        </head>
        <body>
            <header>
            <h1><a href="../index.php"><i class="fas fa-bed"></i> Super Legit Reddit</a></h1>
      <?php if ($username != null) {
        ?>
            <nav>
                <ul>
                <li><?=$username?></li>
                <li><a href="profile.php?id=<?=getUserId($_SESSION['username'])?>">My Profile</a></li>
                <li><a href="../actions/action_logout.php">Logout</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="create_channel.php">Create channel</a></li>
                <li><a href="add_story.php">Add story</a></li>
                </ul>
            </nav>
        <?php
    }else{
        ?>
            <nav>   
                <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
                </ul>
            </nav>
        <?php
    } ?>
            </header>    
<?php
} ?>

<?php function draw_footer()
    {
        ?>
  </body>
</html>
<?php
    } ?>