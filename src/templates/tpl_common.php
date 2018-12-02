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
            <h1><a href="../index.php"><img src="../../res/LogoSmall.png" width = "114" height = "132"> </a></h1>
      <?php if ($username != null) {
        ?>
            <nav>
                <div class="account">
                 <ul>   
                <li><a href="profile.php?id=<?=getUserId($_SESSION['username'])?>"><?=$username?></a></li>
                <li><a href="../actions/action_logout.php">Logout</a></li>
                <ul>
                </div>
                <div class="toolbar">
                <ul>
                <li><a href="search.php">Search</a></li>
                <li><a href="create_channel.php">Create channel</a></li>
                <li><a href="add_story.php">Add story</a></li>
                </div>
                </ul>
            </nav>
        <?php
    }else{
        ?>
            <nav>   
                <div class="account"> 
                <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
                </div>
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