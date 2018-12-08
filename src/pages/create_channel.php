<?php
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_channels.php');

    draw_header($_SESSION['username']);
    draw_channel_adder();
    draw_footer();
?>