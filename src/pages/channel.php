<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_post.php');
  include_once('../database/db_user.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  
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
  $channel = getChannel($id);
  $stories = getChannelStories($id);

  foreach ($stories as $k => $story) {
      $stories[$k]['story_comments'] = getChildComments($story['post_id']);
  }

  draw_header($username);
  ?>
  <section id="channelInfo">
    <form method="post">
      <?php
        if($username){
      ?>
      <button name="subscribe">
      <?php
        if(isUserSubscribed($id, getUserId($_SESSION['username'])))
          echo 'Unsubscribe';
        else
          echo 'Subscribe';
      ?>
      </button>
      <?php
      }
      ?>
      <input type="hidden" name="channel_id" value="<?=$id?>">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
    <ul>
      <li>Name: <?=$channel['channel_name']?></li>
      <li>Subscribers: <?=getNumSubscribers($id)?></li>
    </ul>
  </section>
  <?php
  draw_stories($stories, $id);
  draw_footer();
