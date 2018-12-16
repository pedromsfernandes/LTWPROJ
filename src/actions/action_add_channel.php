<?php
  include_once('../includes/session.php');
  include_once('../includes/image.php');
  include_once('../database/db_story.php');
  include_once('../database/db_user.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_image.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $channel_name = $_POST['channel_name'];

  if (!preg_match("/^[a-zA-Z0-9]+$/", $channel_name)) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Channel name can only be alpha-numeric!');
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $channel_description = $_POST['channel_description'];
  $user_id = getUserId($_SESSION['username']);

  if (($id = getChannelId($channel_name)) !== null) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Channel already exists!');
      header("Location: ../pages/channel.php?id=$id");
  }

  if (exif_imagetype($_FILES['image']['tmp_name']) != IMAGETYPE_JPEG) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Image extension not supported!');
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  };

  insertImage();
  $db = Database::instance()->db();
  $img_id = $db->lastInsertId();

  $channel_id = insertChannel($channel_name, $channel_description, $img_id, $user_id);

  saveImage($img_id);

  header("Location: ../pages/channel.php?id=$channel_id");
