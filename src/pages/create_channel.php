<?php
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');

  draw_header($_SESSION['username']);
?>

    <form action="../actions/action_add_channel.php" method="post">
      <input type="text" name="channel_name" placeholder="Channel name">
      <input type="textarea" name="channel_description" placeholder="What is the channel for?">
      <input type="submit" value="Submit">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>

<?php
  draw_footer();
?>