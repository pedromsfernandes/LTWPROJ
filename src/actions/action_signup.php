<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
      insertUser($username, $password);
      $_SESSION['username'] = $username;
      header('Location: ../pages/home.php');
  } catch (PDOException $e) {
      header('Location: ../pages/signup.php');
  }

?>