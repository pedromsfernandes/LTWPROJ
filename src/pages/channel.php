<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_comment.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

    $id = $_GET['id'];

  $channel = getChannel($id);
  $stories = getChannelStories($id);

  foreach ($stories as $k => $story) {
      $stories[$k]['story_comments'] = getStoryComments($story['story_id']);
  }

  draw_header($_SESSION['username']);
  draw_stories($stories, $id);
  draw_footer();
