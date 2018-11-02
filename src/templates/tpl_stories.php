<?php function draw_stories($stories)
{
    ?>  <section id="stories">

  <?php
    foreach ($stories as $story) {
        draw_story($story, false);
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

<?php function draw_story($story, $comments_on)
    {
        ?>
  <article class="story">
    <header><h2><a href="../pages/story.php?id=<?=$story['story_id']?>"><?=$story['story_title']?></a></h2></header>
    <p><?=$story['story_text']?></p>

    <?php if($comments_on){ ?>
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
      <?php }?>
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