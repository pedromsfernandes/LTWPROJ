<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  $story_id = $_POST['story_id'];
  $comment_text = $_POST['cmt_text'];
  $username = $_SESSION['username'];

  insertComment($comment_text, $story_id, $username);

  header("Location: ../pages/story.php?id=$story_id");
?>