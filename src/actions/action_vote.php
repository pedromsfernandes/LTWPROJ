<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  $story_id = $_POST['story_id'];
  $story_op = $_POST['story_op'];
  $type = $_POST['type'];
  $username = $_SESSION['username'];

  if (!hasVoted($_SESSION['username'], $story_id)) {
      if ($type == "upvote") {
          addVote($story_id, $username);
          addPoint($story_op);
      } else {
          remVote($story_id, $username);
          remPoint($story_op);
      }
  }


  header('Location: ../pages/home.php');
