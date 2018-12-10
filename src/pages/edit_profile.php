<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_user.php');
  include_once('../database/db_story.php');
  include_once('../templates/tpl_profile.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  $user_id = getUserId($_SESSION['username']);
  $profile = getProfile($user_id);

  draw_header($_SESSION['username']);
  draw_profile_editor($profile);
  draw_footer();
