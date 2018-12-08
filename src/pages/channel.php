<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_post.php');
  include_once('../database/db_user.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../templates/tpl_channels.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
    $username = null;
  } else {
    $username = $_SESSION['username'];
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  $id = $_GET['id'];

  if(!is_numeric($id)){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Invalid channel!');
    die(header('Location: ../pages/home.php'));
  }

  $channel = getChannel($id);

  if($channel == null){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No such channel!');
    die(header('Location: ../pages/home.php'));
  }

  $stories = getChannelStories($id);

  foreach ($stories as $k => $story) {
      $stories[$k]['story_comments'] = getChildComments($story['post_id']);
  }

  draw_header($username);
  draw_channel_info($channel);
  draw_stories($stories, $id);
  draw_footer();
