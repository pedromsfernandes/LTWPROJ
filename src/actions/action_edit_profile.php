<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: ../pages/login.php'));
  }

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $username = $_SESSION['username'];
  $new_username = $_POST['username'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $old_password = $_POST['old_password'];
  $description = $_POST['description'];
  $avatar = $_POST['avatar'];

  if(checkUserPassword($username, $old_password)){
    $password;

    if($new_password != '' && $new_password == $confirm_password)
        $password = $new_password;
    else
        $password = $old_password;

    editProfile($new_username, $username, $password, $description, $avatar);
  }

  header("Location: ../pages/home.php");
?>