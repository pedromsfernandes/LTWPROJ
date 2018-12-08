<?php
    include_once('../includes/session.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');

   // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        $answer = 'reject_log';
    }
    else{
        if ($_SESSION['csrf'] !== $_POST['csrf']) {
            $answer = 'reject_csrf';
        }
        else{
            $channel_id = $_POST['channel_id'];
            $user_id = getUserId($_SESSION['username']);
            
            if(!isUserSubscribed($channel_id, $user_id)){
                addSubscription($channel_id, $user_id);
                $aux = getNumSubscribers($channel_id);
                $answer = ['Unsubscribe', $aux];
            }else{
                removeSubscription($channel_id, $user_id);
                $aux = getNumSubscribers($channel_id);
                $answer = ['Subscribe', $aux];
            }
        }
    }

    echo json_encode($answer);
?>