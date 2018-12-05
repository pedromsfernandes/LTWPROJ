<<<<<<< HEAD
<?php
    include_once('../database/db_story.php');
    
    $stories = getAllStoriesByVotes();

    echo json_encode($stories);
=======
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
    }

    echo json_encode($stories);
>>>>>>> 3a84a6dcac15dda9c1622021c83f398912f60894
?>