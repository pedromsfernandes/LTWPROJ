<?php
    include_once('../includes/session.php');
    include_once('../database/db_story.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_post.php');

    $channel = $_POST['channel'];

    if (isset($_SESSION['username'])) 
        $user_id = getUserId($_SESSION['username']);

    switch($channel){
        case -1:
            $stories = getAllStoriesByComments();
            break;
        case -2:
            $stories = getSubscribedStoriesByComments($user_id);
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

        $upvote = 0;
        $downvote = 0;
        if (isset($_SESSION['username'])){
        $vote = postVoted($user_id, $story['post_id']);
            switch($vote['vote']){
                case -1:
                    $downvote = 1;
                    break;
                case 1:
                    $upvote = 1;
                    break;
            }
        }

        $stories[$key]['upvote'] = $upvote;
        $stories[$key]['downvote'] = $downvote;
    }

    echo json_encode($stories);
?>