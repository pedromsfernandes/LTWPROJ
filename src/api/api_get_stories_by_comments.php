<?php
    include_once('../database/db_story.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_post.php');

    $channel = $_POST['channel'];
    
    if($channel == -1)
        $stories = getAllStoriesByComments();
    else
        $stories = getAllStoriesByCommentsFromChannel($channel);
    
    foreach($stories as $key => $story){
       $stories[$key]['user_name'] = getUserName($story['post_op']);
       $stories[$key]['channel'] = getChannel($story['channel_id'])['channel_name'];
       $stories[$key]['tags'] = getStoryTags($story['post_id']);
       $stories[$key]['num_votes'] = getVotes($story['post_id']);
       $stories[$key]['num_comments'] = getNumComments($story['post_id']);
       $stories[$key]['img'] = getImg($story['post_id']);
    }

    echo json_encode($stories);
?>