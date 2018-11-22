<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }


  $stories = getAllStories();
  foreach ($stories as $k => $story) {
      $stories[$k]['story_comments'] = getStoryComments($story['story_id']);
  }

  draw_header($_SESSION['username']);
  draw_stories($stories);
  draw_footer();
?>