<?php
  include_once('../includes/session.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  $cmt_id = $_POST['cmt_id'];
  $cmt_op = $_POST['cmt_op'];
  $type = $_POST['type'];
  $username = $_SESSION['username'];

  if($cmt_op == $username)
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));

    $lastVote = lastCommentVote($username, $cmt_id);
    if(strcmp($type,"upvote")===0){
        if($lastVote == 1){
            remCommentVote($cmt_id, $username);
            remPoint($cmt_op);
        }
        else {
            if($lastVote == -1){
                remCommentVote($cmt_id, $username);
                addPoint($cmt_op);
            }

            addCommentVote($cmt_id, $username, 1);
            addPoint($cmt_op);
        }
    }
    else{
        if($lastVote == -1){
            remCommentVote($cmt_id, $username);
            addPoint($cmt_op);
        }
        else {
            if($lastVote == 1){
                remCommentVote($cmt_id, $username);
                remPoint($cmt_op);
            }

            addCommentVote($cmt_id, $username, -1);
            remPoint($cmt_op);
        }
    }

   header('Location: ' . $_SERVER['HTTP_REFERER']);
