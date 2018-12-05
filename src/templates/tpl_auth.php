<?php function draw_login()
{
    /**
     * Draws the login section.
     */ ?>
  <section id="login">
    
    <header>
    <div class="login-flexbox">
      <a href="signup.php">Sign Up</a>
      <a class="active" href="login.php">Log In</a>
  </div>
    </header>

    <form method="post" action="../actions/action_login.php">
      <input type="text" name="username" placeholder="username" required>
      <input type="password" name="password" placeholder="password" required>
      <input type="submit" value="Login">
    </form>

  </section>
<?php
} ?>

<?php function draw_signup()
    {
        /**
         * Draws the signup section.
         */ ?>
  <section id="signup">

    <header>
    <div class="login-flexbox">
      <a class="active" href="signup.php">Sign Up</a>
      <a href="login.php">Log In</a>
  </div>
    </header>

    <form method="post" action="../actions/action_signup.php">
      <input type="text" name="username" placeholder="username" required>
      <input type="password" name="password" placeholder="password" required>
      <input type="submit" value="Get Started">
    </form>

  </section>
<?php
    } ?>