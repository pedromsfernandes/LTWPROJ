<?php
  include_once('../includes/session.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $story_id = $_POST['story_id'];
  $comment_text = $_POST['cmt_text'];
  $user_id = getUserId($_SESSION['username']);

  insertComment($comment_text, $story_id, $user_id);

  header("Location: ../pages/story.php?id=$story_id");
?>