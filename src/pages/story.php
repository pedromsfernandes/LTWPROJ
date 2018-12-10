<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_post.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
    $username = null;
  } else {
    $username = $_SESSION['username'];
  }

  $id = $_GET['id'];

  if(!is_numeric($id)){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Invalid story!');
    die(header('Location: ../pages/home.php'));
  }

  $story = getStory($id);

  if($story == null){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No such story!');
    die(header('Location: ../pages/home.php'));
  }

  $story['story_comments'] = getChildComments($story['post_id']);

  draw_header($username);
  draw_story($story, true);
  draw_footer();
