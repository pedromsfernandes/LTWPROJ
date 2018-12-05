<?php
    include_once('../database/db_story.php');
    
    $stories = getAllStoriesByVotes();

    echo json_encode($stories);
?>