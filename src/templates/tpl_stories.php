<?php function draw_stories($stories, $add = false)
{
    ?>  <section id="stories">

  <?php
    foreach ($stories as $story) {
        draw_story($story, false);
    }

    if ($add) {
        ?>
  <article class="new-story">
    <form action="../actions/action_add_story.php" method="post">
      <input type="text" name="story_title" placeholder="Add story">
      <input type="textarea" name="story_text" placeholder="What's on your mind?">
      <input type="submit" value="Submit">
    </form>
  </article>

  </section>
<?php
    }
} ?>

<?php function draw_story($story, $comments_on)
{
    ?>
  <article class="story">
  <form method="post" action="../actions/action_vote.php">
  <button name="upvote" type="submit"> Upvote </button>
  <input type="hidden" name="story_op" value="<?=$story['username']?>">
  <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
  <input type="hidden" name="type" value="upvote">
  </form>

    <form method="post" action="../actions/action_vote.php">
  <button name="downvote" type="submit"> Downvote </button>
  <input type="hidden" name="story_op" value="<?=$story['username']?>">
  <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
  <input type="hidden" name="type" value="downvote">
  </form>
  
  <p>Votes: <?=$story['story_votes'] ?></p>

    <header><h2><a href="../pages/story.php?id=<?=$story['story_id']?>"><?=$story['story_title']?></a></h2></header>
    <p><?=$story['story_text']?></p>
    <footer>Submitted by: <?=$story['username']?> on <?=$story['story_date']?></footer>

    <?php if ($comments_on) {
        ?>
    <ol>
      <?php
            draw_comments($story['story_comments']); ?>
    </ol>
        <form action="../actions/action_add_comment.php" method="post">
      <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
      <input type="textarea" name="cmt_text" placeholder="Add comment">
    </form>
      <?php
    } ?>
  </article>
<?php
} ?>

<?php function draw_comment($comment)
    {
        ?>
  <li>
      <?=$comment['cmt_text']?> <br>by <?=$comment['username']?>
  </li>
<?php
    }
    function draw_comments($comments)
    {
        foreach ($comments as $comment) {
            draw_comment($comment);
        }
    }
    
    
    ?>

