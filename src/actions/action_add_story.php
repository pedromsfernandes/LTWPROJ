<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $story_title = $_POST['story_title'];
  $story_text = $_POST['story_text'];
  $channel_id = $_POST['channel_id'];
  $user_id = getUserId($_SESSION['username']);
  $tags = $_POST['tags'];

  insertStory($story_title, $story_text, $user_id, $channel_id, $tags);

  header('Location: ../pages/home.php');
?>