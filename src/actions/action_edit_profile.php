<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'You\'re not logged in!');
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $username = $_SESSION['username'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $old_password = $_POST['old_password'];
  $description = $_POST['description'];
  $avatar = $_POST['avatar'];

  if(checkUserPassword($username, $old_password)){

    if($new_password != '' && $new_password == $confirm_password)
        $password = $new_password;
    else
        $password = $old_password;

    editProfile($username, $password, $description, $avatar);
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>