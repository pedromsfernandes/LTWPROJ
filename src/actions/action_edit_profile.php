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
  $password = $_POST['password'];
  $description = $_POST['description'];
  
  if(checkUserPassword($username, $password)){

    $img_id = getProfile($id)['user_avatar'];
    if(is_uploaded_file($_FILES['image']['tmp_name'])){

      if (!preg_match("/.*.(jpg|jpeg)/", $_FILES['image']['name'], $matches)) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Image extension not supported!');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    };

      insertImage();
      $db = Database::instance()->db();
      $img_id = $db->lastInsertId();
      saveImage($img_id);
    }

    editProfile($username, $description, $img_id);

    header("Location: ../pages/profile.php?id=$id");
  }
  else
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  ?>