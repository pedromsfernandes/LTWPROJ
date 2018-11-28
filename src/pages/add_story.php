<?php
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');

  draw_header($_SESSION['username']);
?>

<article class="new-story">
    <form action="../actions/action_add_story.php" method="post">
      <input type="text" name="story_title" placeholder="Add story">
      <input type="textarea" name="story_text" placeholder="What's on your mind?">
      <input type="hidden" name="channel_id" value="<?=$channel_id?>">
      <input type="submit" value="Submit">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
  </article>

<?php
  draw_footer();
?>