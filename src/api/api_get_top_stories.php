<?php
    include_once('../database/db_story.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_post.php');
    
    $stories = getAllStoriesByVotes();

    foreach($stories as $key => $story){
       $stories[$key]['user_name'] = getUserName($story['post_op']);
       $stories[$key]['channel'] = getChannel($story['channel_id'])['channel_name'];
       $stories[$key]['tags'] = getStoryTags($story['post_id']);
       $stories[$key]['num_comments'] = getNumComments($story['post_id']);
    }

    echo json_encode($stories);
?>