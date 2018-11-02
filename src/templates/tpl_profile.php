<?php function draw_profile($profile)
{
    ?>
    <p>Username: <?=$profile['username']?></p>
    <p>Description: <?=$profile['description']?></p>
    <p>Points: <?=$profile['points']?></p>
<?php
} ?>