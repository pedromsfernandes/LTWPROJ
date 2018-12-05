<<<<<<< HEAD
<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');
  include_once('../database/db_channel.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $channel_name = $_POST['channel_name'];
  $channel_description = $_POST['channel_description'];
  $user_id = getUserId($_SESSION['username']);

  if(getChannelId($channel_name) !== null){
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $channel_id = insertChannel($channel_name, $channel_description, $user_id);

  header("Location: ../pages/channel.php?id=$channel_id");
=======
<?php
  include_once('../includes/session.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');
  include_once('../database/db_channel.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $channel_name = $_POST['channel_name'];
  $channel_description = $_POST['channel_description'];
  $user_id = getUserId($_SESSION['username']);

  if(($id = getChannelId($channel_name)) !== null){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Channel already exists!');
    header("Location: ../pages/channel.php?id=$id");
  }

  $channel_id = insertChannel($channel_name, $channel_description, $user_id);

  header("Location: ../pages/channel.php?id=$channel_id");
>>>>>>> 3a84a6dcac15dda9c1622021c83f398912f60894
?>