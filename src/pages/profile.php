<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_user.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../templates/tpl_profile.php');
  include_once('../database/db_post.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  $user_id = $_GET['id'];

  if(!is_numeric($user_id)){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Invalid profile!');
    die(header('Location: ../pages/home.php'));
  }

  $profile = getProfile($user_id);

  if($profile == null){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No such profile!');
    die(header('Location: ../pages/home.php'));
  }

  $stories = getUserStories($user_id);
  $comments = getUserComments($user_id);


  draw_header($_SESSION['username']);
  draw_profile($profile); 
  
  if($user_id === getUserId($_SESSION['username'])){
      ?>
<div class = "editProfile">
  <a href="edit_profile.php">Edit Profile</a>
  </div>
<?php
  }


  if($stories != null)
    draw_stories($stories);

  if($comments != null)
    draw_comments($comments, false);

  draw_footer();
