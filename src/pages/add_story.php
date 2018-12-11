<?php
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');
    include_once('../database/db_post.php');

    draw_header($_SESSION['username']); 
    draw_new_story_buttons();
    draw_footer();
?>