<?php
    include_once('../includes/session.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');

   // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        die(header('Location: ../pages/login.php'));
    }

    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }

    $channel_id = $_POST['channel_id'];
    $user_id = getUserId($_SESSION['username']);
    
    if(!isUserSubscribed($channel_id, $user_id))
        addSubscription($channel_id, $user_id);
    else
        removeSubscription($channel_id, $user_id);

   header("Location: ../pages/channel.php?id=$channel_id");
?>