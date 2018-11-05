<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  $story_id = $_POST['story_id'];
  $username = $_POST['story_op'];
  $type = $_POST['type'];

  if($type == "upvote"){
    addVote($story_id);
    addPoint($username);
  }
  else{
    remVote($story_id);
    remPoint($username);
  }

  header('Location: ../pages/home.php');
?>