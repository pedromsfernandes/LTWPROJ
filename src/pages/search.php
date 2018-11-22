<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_story.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  draw_header($_SESSION['username']);

  ?>

  <form method="post" id="searchform"> 
    <input type="text" name="search_text"> 
    <select name="search_type">
        <option value="stories">Stories</option>
        <option value="comments">Comments</option>
    </select>
    <input type="submit" name="submit" value="Search"> 
  </form> 

  <?php
    if (isset($_POST['submit']) && preg_match("/[A-Z  | a-z]+/", $_POST['search_text'])) {
        $search_text = $_POST['search_text'];
        $search_type = $_POST['search_type'];

        if ($search_type == 'stories') {
            $stories = searchStories($search_text);
            draw_stories($stories);
        } elseif ($search_type == 'comments') {
            $comments = searchComments($search_text);
            draw_comments($comments);
        }
    }
  draw_footer();
