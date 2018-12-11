<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_post.php');
  include_once('../database/db_channel.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in

  if (!isset($_SESSION['username'])) {
    die(header('Location: all.php'));
  }

  $stories = getSubscribedStories(getUserId($_SESSION['username']));
  
  foreach ($stories as $k => $story) {
      $stories[$k]['story_comments'] = getChildComments($story['post_id']);
  }

  draw_header($_SESSION['username']);
  draw_stories($stories);
  draw_footer();
?>