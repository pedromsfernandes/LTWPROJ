<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../templates/tpl_channels.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_story.php');
  include_once('../database/db_post.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  draw_header($_SESSION['username']);

  ?>

  <form method="get" id="searchform"> 
    <input type="text" name="search_text"> 
    <select name="search_type">
        <option value="stories">Stories</option>
        <option value="comments">Comments</option>
        <option value="channels">Channels</option>
    </select>
    <input type="submit" name="submit" value="Search"> 
  </form> 

  <?php
    if (isset($_GET['submit']) && preg_match("/[A-Z  | a-z]+/", $_GET['search_text'])) {
        $search_text = $_GET['search_text'];
        $search_type = $_GET['search_type'];

        if ($search_type == 'stories') {

            if(strstr($search_text, '#')){
                $tok = strtok($search_text," \n");

                $tags = array();
                while ($tok !== false) {
                    array_push($tags, substr($tok, 1));
                    $tok = strtok(" ");
                }

                $stories = searchStoriesByTags($tags);
            }
            else{
                $stories = searchStories($search_text);
            }

            draw_stories($stories);
        } else if ($search_type == 'comments') {
            $comments = searchComments($search_text);
            draw_comments($comments);
        }
        else if ($search_type == 'channels') {
            $channels = searchChannels($search_text);
            draw_channels($channels);
        }
    }
  draw_footer();
