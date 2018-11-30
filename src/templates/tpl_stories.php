<?php function draw_stories($stories, $channel_id = null)
{
    ?>  <section id="stories">

  <section id="sorting">
    <input type="button" value = "Top">
    <input type="button" value = "New">
  </section>

  <?php
    foreach ($stories as $story) {
        draw_story($story, false);
    }

    if ($channel_id) {
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

  </section>
<?php
    }
} ?>

<?php function draw_story($story, $comments_on)
{
    ?>
  <article class="story">

  <form method="post" action="../actions/action_vote.php">
  <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
  <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
  <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
  <input type="hidden" name="type" value="upvote">
  <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>

    <form method="post" action="../actions/action_vote.php">
  <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
  <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
  <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
  <input type="hidden" name="type" value="downvote">
  <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
  
  <p>Votes: <?=getVotes($story['post_id']) ?></p>

    <header><h2><a href="../pages/story.php?id=<?=$story['post_id']?>"><?=$story['post_title']?></a></h2></header>
    <p><?=$story['post_text']?></p>
    <footer>Submitted by: <?=getUserName($story['post_op'])?> on <?=$story['post_date']?> to <a href="../pages/channel.php?id=<?=$story['channel_id']?>"><?=getChannel($story['channel_id'])['channel_name']?></a></footer>

    <?php if ($comments_on) {
        ?>
    <ol>
      <?php
            draw_comments($story['story_comments']); ?>
    </ol>
        <form action="../actions/action_add_comment.php" method="post">
      <input type="hidden" name="story_id" value="<?=$story['post_id']?>">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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
  <p>Votes: <?=getVotes($comment['post_id']) ?></p>
  <form method="post" action="../actions/action_vote.php">
  <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
  <input type="hidden" name="post_op" value="<?=$comment['post_op']?>">
  <input type="hidden" name="post_id" value="<?=$comment['post_id']?>">
  <input type="hidden" name="type" value="upvote">
  <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>

    <form method="post" action="../actions/action_vote.php">
  <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
  <input type="hidden" name="post_op" value="<?=$comment['post_op']?>">
  <input type="hidden" name="post_id" value="<?=$comment['post_id']?>">
  <input type="hidden" name="type" value="downvote">
  <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
      <?=$comment['post_text']?> <br>by <?=getUserName($comment['post_op'])?>
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

