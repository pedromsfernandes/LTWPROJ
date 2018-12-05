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
      die(header('Location: login.php'));
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

  draw_header($_SESSION['username']);
  ?>
  <form method="post" action="../actions/action_subscribe_channel.php">
  <button name="subscribe" type="submit"><?php
    if(isUserSubscribed($id, getUserId($_SESSION['username'])))
      echo 'Unsubscribe';
    else
      echo 'Subscribe';
  ?></button>
  <input type="hidden" name="channel_id" value="<?=$id?>">
  <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
  <ul>
    <li>Name: <?=$channel['channel_name']?></li>
    <li>Subscribers: <?=getNumSubscribers($id)?></li>
    <?php $user = getUserName($channel['channel_creator']);
      if($user !== null){
          ?>
      <li>Creator: 
      <?php echo $user;
      }?>
      </li>
  </ul>
  <?php
  draw_stories($stories, $id);
  draw_footer();
