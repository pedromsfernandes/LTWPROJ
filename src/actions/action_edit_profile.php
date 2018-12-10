<?php
  include_once('../includes/session.php');
  include_once('../includes/image.php');
  include_once('../database/db_user.php');
  include_once('../database/db_image.php');

  //session_regenerate_id(true);

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'You\'re not logged in!');
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $username = $_SESSION['username'];
  $id = getUserId($username);
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $old_password = $_POST['old_password'];
  $description = $_POST['description'];
  
  if(checkUserPassword($username, $old_password)){

    if($new_password != '' && $new_password == $confirm_password)
        $password = $new_password;
    else
        $password = $old_password;

    $img_id = null;
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      insertImage();
      $db = Database::instance()->db();
      $img_id = $db->lastInsertId();
      saveImage($img_id);
    }

    editProfile($username, $password, $description, $img_id);

    header("Location: ../pages/profile.php?id=$id");
  }
  else
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  ?>