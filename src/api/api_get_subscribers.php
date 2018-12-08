<?php
    include_once('../database/db_channel.php');

    $channel_id = $_POST['channel_id'];

    $answer = getNumSubscribers($channel_id);

    echo json_encode($answer);
?>