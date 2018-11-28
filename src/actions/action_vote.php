<?php
  include_once('../includes/session.php');
  include_once('../database/db_post.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $post_id = $_POST['post_id'];
  $post_op = $_POST['post_op'];
  $type = $_POST['type'];
  $user_id = getUserId($_SESSION['username']);

  if($post_op == $user_id)
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));

    $lastVote = lastVote($user_id, $post_id);
    if(strcmp($type,"upvote")===0){
        if($lastVote == 1){
            remVote($post_id, $user_id);
            remPoint($post_op);
        }
        else {
            if($lastVote == -1){
                remVote($post_id, $user_id);
                addPoint($post_op);
            }

            addVote($post_id, $user_id, 1);
            addPoint($post_op);
        }
    }
    else{
        if($lastVote == -1){
            remVote($post_id, $user_id);
            addPoint($post_op);
        }
        else {
            if($lastVote == 1){
                remVote($post_id, $user_id);
                remPoint($post_op);
            }

            addVote($post_id, $user_id, -1);
            remPoint($post_op);
        }
    }

   header('Location: ' . $_SERVER['HTTP_REFERER']);
