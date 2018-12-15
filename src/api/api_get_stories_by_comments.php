<?php
    include_once('../includes/session.php');
    include_once('../database/db_story.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_post.php');

    $channel = $_POST['channel'];

    switch($channel){
        case -1:
            $stories = getAllStoriesByComments();
            break;
        case -2:
            $stories = getSubscribedStories(getUserId($_SESSION['username']));
            break;
        default:
            $stories = getAllStoriesByCommentsFromChannel($channel);
            break;
    }
    
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