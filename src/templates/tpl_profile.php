<?php function draw_profile($profile)
{
    ?>
    <div class ="profile">
        <p>Username: <?=$profile['user_name']?></p>
        <p>Description: <?=htmlentities($profile['user_description'])?></p>
        <p>Points: <?=$profile['user_points']?></p>
        <p>Avatar: </p>
        <img src="../images/originals/<?=$profile['user_avatar']?>.jpg">
    </div>
<?php
} 

function draw_profile_editor($profile){?>
<article class="profile-editor">
  <form method="post" action="../actions/action_edit_profile.php" enctype="multipart/form-data">
    <label for="username">Username: </label> <input type="text" name="username" value=<?=$profile['user_name']?> readonly>
    <label for="description">Description: </label> <input type="textarea" name="description" placeholder="Add something about yourself" value=<?=htmlspecialchars($profile['user_description'])?>>
    <label for="avatar">Avatar: </label> <input type="file" name="image" id="file" class="inputfile" >
    <label for="file"><i class="fas fa-upload"></i> Choose a file</label>
    <label for="password">Confirm password:  </label> <input type="password" name="password" required>
    <input type="submit" name="submit" value="Submit">
    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
</article>
    <?php
}