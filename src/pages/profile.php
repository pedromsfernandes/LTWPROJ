<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_user.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../templates/tpl_profile.php');
  include_once('../database/db_post.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  $user_id = getUserId($_SESSION['username']);
  $profile = getProfile($user_id);
  $stories = getUserStories($user_id);
  $comments = getUserComments($user_id);


  draw_header($_SESSION['username']);
  draw_profile($profile); ?>

  <a href="edit_profile.php">Edit Profile</a>
  <?php

  draw_stories($stories);

  draw_comments($comments);

  draw_footer();
