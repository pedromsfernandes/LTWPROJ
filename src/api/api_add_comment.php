<?php
  include_once('../includes/session.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {    
      $answer = 'reject_log';
  } else {
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['cmt_text'];
    $user_id = getUserId($_SESSION['username']);

    insertComment($comment_text, $post_id, $user_id);

    $answer = [$post_id, $comment_text];
  }

  echo json_encode($answer);
