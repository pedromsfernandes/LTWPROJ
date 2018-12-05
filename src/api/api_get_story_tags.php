<?php
    include_once('../database/db_post.php');

    $story_id = $_POST['story_id'];

    $tags = getStoryTags($story_id);

    echo json_encode($tags);
?>