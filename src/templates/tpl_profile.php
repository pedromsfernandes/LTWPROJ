<?php function draw_profile($profile)
{
    ?>
    <p>Username: <?=$profile['user_name']?></p>
    <p>Description: <?=$profile['user_description']?></p>
    <p>Points: <?=$profile['user_points']?></p>
    <p>Avatar: </p>
    <img src="<?=$profile['user_avatar']?>">
<?php
} ?>