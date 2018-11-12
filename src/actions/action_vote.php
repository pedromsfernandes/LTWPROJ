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

  if($story_op == $username)
    //die(header("Location: ../pages/story.php?id=$story_id"));

    if($type == "upvote"){

        if(!hasUpvoted($username, $story_id)){
            addVote($story_id, $username);
            addPoint($story_op);
        }
        else {
            remVote($story_id, $username);
            remPoint($story_op);
        }

    }
    else{

        if(!hasDownvoted($username, $story_id)){
            remVote($story_id, $username);
            remPoint($story_op);
        }
        else {
            addVote($story_id, $username);
            addPoint($story_op);
        }

    }

  //header("Location: ../pages/story.php?id=$story_id");
