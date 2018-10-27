<?php function draw_stories($stories)
{
    ?>  <section id="stories">

  <?php
    foreach ($stories as $story) {
        draw_story($story);
    } ?>

  <article class="new-story">
    <form action="../actions/action_add_story.php" method="post">
      <input type="text" name="story_title" placeholder="Add story">
      <input type="textarea" name="story_text" placeholder="What's on your mind?">
      <input type="submit" value="Submit">
    </form>
  </article>

  </section>
<?php
} ?>

<?php function draw_story($story)
    {
        ?>
  <article class="story">
    <header><h2><?=$story['story_title']?></h2></header>
    <p><?=$story['story_text']?></p>
    <ol>
      <?php
        foreach ($story['story_comments'] as $comment) {
            draw_comment($comment);
        } ?>
    </ol>

    <form action="../actions/action_add_comment.php" method="post">
      <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
      <input type="textarea" name="cmt_text" placeholder="Add comment">
    </form>

  </article>
<?php
    } ?>

<?php function draw_comment($comment)
    {
        ?>
  <li>
      <?=$comment['cmt_text']?>
  </li>
<?php
    } ?>