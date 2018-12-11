<?php

include_once('../database/db_user.php');

function draw_header($username)
{
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
            <script src="../scripts/script.js" defer></script>
        </head>
        <body> 
            <header>
        <?php if ($username != null) {
            ?>
            <nav id="mySidenav" class="sidenav">
                <a href="../index.php"><img src="../../res/LogoSmall.png"> </a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="profile.php?id=<?=getUserId($_SESSION['username'])?>"><i class="fas fa-user"></i> <?=$username?></a>
                <a href="../actions/action_logout.php"><i class="fas fa-arrow-left"></i> Logout</a>
                <a href="../index.php"> <i class="fa fa-home"></i> Home</a>
                <a href="search.php"><i class="fas fa-search"></i> Search</a>
                <a href="create_channel.php"><i class="fas fa-plus-circle"></i> Create channel</a>
                <a href="add_story.php"><i class="fas fa-plus-circle"></i> Add story</a>
            </nav>
            <div class="menu">
             <span  onclick="openNav()">&#9776; Menu</span>
            </div>
             <div class = "header-flexbox">      
                <a href="../index.php"><img src="../../res/LogoSmall.png"> </a>
                <div style= "order: 3" class="account">
                    <nav>
                        <ul>   
                        <li><a href="profile.php?id=<?=getUserId($_SESSION['username'])?>"><i class="fas fa-user"></i> <?=$username?></a></li>
                        <li><a href="../actions/action_logout.php"><i class="fas fa-arrow-left"></i> Logout</a></li>
                        <ul>
                    </nav>
                </div>
                <div style= "order: 2" class="toolbar">
                    <nav>
                        <ul>
                        <li><a href="../index.php"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="search.php"><i class="fas fa-search"></i> Search</a></li>
                        <li><a href="create_channel.php"><i class="fas fa-plus-circle"></i> Create channel</a></li>
                        <li><a href="add_story.php"><i class="fas fa-plus-circle"></i> Add story</a></li>
                    </nav>
                </div>
                    </ul>
                </nav>
            <?php
        }else{
            ?>
            <nav id="mySidenav" class="sidenav">
                <a href="../index.php"><img src="../../res/LogoSmall.png"> </a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="signup.php"><i class="fas fa-pencil-alt"></i> Signup</a>
            </nav>
            <div class="menu">
                <span onclick="openNav()">&#9776; Menu</span>
            </div>
             <div class = "header-flexbox">   
             <a href="../index.php"><img src="../../res/LogoSmall.png"> </a>     
                <div class="account">
                    <nav>  
                        <ul>
                        <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="signup.php"><i class="fas fa-pencil-alt"></i> Signup</a></li>
                    </nav> 
                </div>
            </div>
                    </ul>
                </nav>
            <?php
        } ?>
            </div>
            </header>   
            <?php if (isset($_SESSION['messages'])) {?>
        <section id="messages">
          <?php foreach($_SESSION['messages'] as $message) { ?>
            <div class="<?=$message['type']?>"><?=$message['content']?></div>
          <?php } ?>
        </section>
      <?php unset($_SESSION['messages']); } ?> 
<?php
} ?>

<?php function draw_footer()
    {
        ?>
  </body>
</html>
<?php
    } ?>

    <?php function draw_header_login()
        {
            ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
            <script src="../scripts/script.js" defer></script>
        </head>
        <body> 
            <div class="login-header">
            <header>
                <h1><a href="../index.php"><img src="../../res/LogoSmall.png" width = "114" height = "132"> </a></h1>
            </header>   
            </div>
            <?php if (isset($_SESSION['messages'])) {?>
        <section id="messages">
          <?php foreach($_SESSION['messages'] as $message) { ?>
            <div class="<?=$message['type']?>"><?=$message['content']?></div>
          <?php } ?>
        </section>
      <?php unset($_SESSION['messages']); } ?> 
       <?php } ?>