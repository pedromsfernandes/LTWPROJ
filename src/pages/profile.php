<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php'); 
  include_once('../database/db_user.php');
  include_once('../templates/tpl_profile.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  $profile = getProfile($_SESSION['username']);

  draw_header($_SESSION['username']);
  draw_profile($profile);
  draw_footer();
