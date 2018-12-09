<?php
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');
    include_once('../database/db_post.php');

    draw_header($_SESSION['username']);  
    draw_story_adder();
    draw_footer();
?>
<article class="new-element">
    <form action="../actions/action_add_story.php" method="post">
      <input type="text" name="story_title" placeholder="Add story">
      <input type="textarea" name="story_text" placeholder="What's on your mind?">
      <div class="choice-select" style="width:200px;">
        <select name="channel_id" required> <?php
        draw_select_channels(getAllChannels());
  ?>
        </select>
      </div>
      <select name="tags[]" multiple> <?php
      draw_select_tags(getAllTags());
?>
      </select>
      <input type="submit" value="Submit">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
</article>
<?php
  draw_footer();
?>