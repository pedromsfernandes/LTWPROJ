<<<<<<< HEAD
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

  
  $post_id = $_POST['post_id'];
  $comment_text = $_POST['cmt_text'];
  $user_id = getUserId($_SESSION['username']);

  insertComment($comment_text, $post_id, $user_id);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
=======
<?php
  include_once('../includes/session.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'You\'re not logged in!');
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $post_id = $_POST['post_id'];
  $comment_text = $_POST['cmt_text'];
  $user_id = getUserId($_SESSION['username']);

  insertComment($comment_text, $post_id, $user_id);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
>>>>>>> 3a84a6dcac15dda9c1622021c83f398912f60894
