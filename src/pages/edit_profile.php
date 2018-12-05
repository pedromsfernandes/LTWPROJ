<?php
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_stories.php');
  include_once('../database/db_channel.php');
  include_once('../database/db_user.php');
  include_once('../database/db_story.php');
  include_once('../templates/tpl_profile.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {
      die(header('Location: login.php'));
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  $user_id = getUserId($_SESSION['username']);
  $profile = getProfile($user_id);

  draw_header($_SESSION['username']);

  ?>

  <form method="post" action="../actions/action_edit_profile.php">
    <label for="username">Username: </label> <input type="text" name="username" value=<?=$profile['user_name']?> readonly>
    <label for="new_password">New Password:  </label> <input type="password" name="new_password">
    <label for="confirm_password">Confirm New Password:  </label> <input type="password" name="confirm_password">
    <label for="description">Description: </label> <input type="textarea" name="description" placeholder="Add something about yourself" value=<?=$profile['user_description']?>>
    <label for="avatar">Avatar URL: </label> <input type="text" name="avatar" placeholder="Paste an image URL" value=<?=$profile['user_avatar']?>>
    <label for="old_password">Confirm Old Password:  </label> <input type="password" name="old_password" required>
    <input type="submit" name="submit" value="Submit">
    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
  
<?php
  draw_footer();
