<?php function draw_stories($stories, $channel_id = null)
{
    ?>  <section id="stories">

  <section id="sorting">
    <input type="button" value = "Top">
    <input type="button" value = "New">
  </section>

  <section id="list">
  <?php
    foreach ($stories as $story) {
        draw_story($story, false);
    }
  ?>
  </section>

  <?php
    if ($channel_id) {
  ?>

  <article class="new-story">
    <form action="../actions/action_add_story.php" method="post">
      <input type="text" name="story_title" placeholder="Add story">
      <input type="textarea" name="story_text" placeholder="What's on your mind?">
      <input type="hidden" name="channel_id" value="<?=$channel_id?>">
      <select name="tags[]" multiple> <?php
      draw_select_tags(getAllTags());
?>
      </select>
      <input type="submit" value="Submit">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
  </article>

  </section>
<?php
    }
} 

function draw_select_tag($tag){
  ?>
  <option value=<?=$tag['tag_id']?>><?=$tag['tag_text']?></option>
  <?php
}

function draw_select_tags($tags){
  foreach($tags as $tag){
    draw_select_tag($tag);
  }
}

function draw_select_channel($channel){
  ?>
  <option value=<?=$channel['channel_id']?>><?=$channel['channel_name']?></option>
  <?php
}

function draw_select_channels($channels){
  foreach($channels as $channel){
    draw_select_channel($channel);
  }
}

function draw_story($story, $comments_on)
{
    ?>
  <article class="story">

    <header><h2><a href="../pages/story.php?id=<?=$story['post_id']?>"><?=$story['post_title']?></a></h2></header>
    <p><?=
    preg_replace("/\[([0-9a-zA-Z]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/","<a href=\"$2\">$1</a>",$story['post_text']);
    ?></p>
    <ul>
    <?php
      draw_tags($story['post_id']);
    ?>
    </ul>
    <footer>Submitted by: <?=getUserName($story['post_op'])?> on <?=$story['post_date']?> to <a href="../pages/channel.php?id=<?=$story['channel_id']?>"><?=getChannel($story['channel_id'])['channel_name']?></a></footer>
  <div class="votes">
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
  
  <p><?=getVotes($story['post_id']) ?></p>
</div>
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
} 

function draw_tags($story_id){
  $tags = getStoryTags($story_id);

  foreach($tags as $tag){
    ?>
    <li><?=$tag['tag_text']?></li>
    <?php
  }
}

function draw_comment($comment)
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
      <?php  

        function getUserLink($matches){
          $id = getUserId($matches[1]);
          return "<a href=\"profile.php?id=$id\">$matches[0]</a>";
        }

        function getChannelLink($matches){
          $id = getChannelId($matches[1]);
          return "<a href=\"channel.php?id=$id\">$matches[0]</a>";
        }
      
      $links_on = preg_replace("/\[([0-9a-zA-Z]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/","<a href=\"$2\">$1</a>",$comment['post_text']);
             $user_tags_on = preg_replace_callback("/\/u\/([a-zA-Z0-9]*)/","getUserLink",$links_on);
             echo preg_replace_callback("/\/c\/([a-zA-Z0-9]*)/","getChannelLink",$user_tags_on);
?> <br>by <?=getUserName($comment['post_op'])?>
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

