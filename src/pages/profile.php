<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
  include_once('../database/db_user.php');
  include_once('../database/db_story.php');
  include_once('../templates/tpl_profile.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  $profile = getProfile($_SESSION['username']);
  $stories = getUserStories($_SESSION['username']);
  $comments = getUserComments($_SESSION['username']);


  draw_header($_SESSION['username']);
  draw_profile($profile); ?>

  <a href="edit_profile.php">Edit Profile</a>
  <?php

  draw_stories($stories);

  draw_comments($comments);

  draw_footer();
