<?php
    include_once('../database/db_user.php');

    $story_op = $_POST['story_op'];

    $username = getUserName($story_op);

    echo json_encode($username);
?>