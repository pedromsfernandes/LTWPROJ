<?php function draw_channels($channels){
?>
<ul>
<?php
    foreach($channels as $channel){?>
    <li><a href="../pages/channel.php?id="<?=$channel['channel_id']?>><?=$channel['channel_name']?></a></li>
<?php
    }
    ?>


</ul>
    <?php
}