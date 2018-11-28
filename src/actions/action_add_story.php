<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  $story_title = $_POST['story_title'];
  $story_text = $_POST['story_text'];
  $channel_id = $_POST['channel_id'];
  $user_id = getUserId($_SESSION['username']);

  insertStory($story_title, $story_text, $user_id, $channel_id);

  header('Location: ../pages/home.php');
?>