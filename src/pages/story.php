<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_channel.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  $id = $_GET['id'];

  $story = getStory($id);
  $story['story_comments'] = getStoryComments($story['story_id']);

  draw_header($_SESSION['username']);
  draw_story($story, true);
  draw_footer();
