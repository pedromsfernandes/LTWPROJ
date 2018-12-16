<?php function draw_stories($stories, $channel_id = null)
{
    ?>  
  <section id="stories">

    <?php
    if($channel_id != -1){
    ?>

    <section id="sorting">
        <input type="button" value = "Top">
        <input type="button" value = "New">
        <input type="button" value = "Most commented">
    </section>

    <?php
    }
    ?>

    <section id="list">
  <?php
    foreach ($stories as $story) {
        draw_story_titles($story);
    } ?>
    </section>

  </section>
  <?php
}

function draw_select_tag($tag)
{
    ?>
    <label class="container">
    <input type="checkbox" name="tags[]" value=<?=$tag['tag_id']?>><?=$tag['tag_text']?>
    <span class="checkmark"></span>
    </label>
  <?php
}

function draw_select_tags($tags)
{
    foreach ($tags as $tag) {
        draw_select_tag($tag);
    }
}

function draw_select_channel($channel)
{
    ?>
  <option value=<?=$channel['channel_id']?>><?=$channel['channel_name']?></option>
  <?php
}

function draw_select_channels($channels)
{
    foreach ($channels as $channel) {
        draw_select_channel($channel);
    }
}
function draw_story_titles($story)
{
  $upvote = "v0";
  $downvote = "v0";
  if (isset($_SESSION['username'])) {  
    $vote = postVoted(getUserId($_SESSION['username']), $story['post_id']);
      switch($vote['vote']){
        case -1:
          $downvote = "v1";
          break;
        case 1:
          $upvote = "v1";
          break;
      }
  }
    ?>
    <div class="titles">
      <div class="flex-container-1">
        <div style= "order: 4" class="title">
          <header><a href="../pages/story.php?id=<?=$story['post_id']?>"><?=htmlentities($story['post_title'])?></a></header>
        </div>
        <div style= "order: 1" class="vote" id="<?=$upvote?>">
            <button name="upvote"> <i class="fas fa-chevron-up"></i> </button>
            <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
            <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
            <input type="hidden" name="type" value="upvote">
        </div>
        <div style= "order: 3" class="vote" id="<?=$downvote?>">
            <button name="downvote">  <i class="fas fa-chevron-down"></i> </button>
            <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
            <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
            <input type="hidden" name="type" value="downvote">
        </div>
        <div style= "order: 2" class="vote-amount">
          <p><?=getVotes($story['post_id']) ?></p>
        </div>
      </div>
      <div class="flex-container-2">
      <?php
        draw_story_img($story);
      ?>
        <ul>
        <?php
          draw_tags($story['post_id']); ?>
        </ul>
        <?php draw_story_footer($story); ?>
      </div>
    </div>
  <?php
}

function draw_story_footer($story)
{
    ?>
  <footer>Submitted by: <a href="profile.php?id=<?=$story['post_op']?>"><?=getUserName($story['post_op'])?></a> on <?=$story['post_date']?> <?php
  if (basename($_SERVER['PHP_SELF']) !== 'channel.php') {
      ?>
  to <a href="../pages/channel.php?id=<?=$story['channel_id']?>"><?=getChannel($story['channel_id'])['channel_name']?></a>
    <?php
  } ?>
      <div class="num-comments">
      <a href="../pages/story.php?id=<?=$story['post_id']?>"><i class="fas fa-comment-dots"></i> <?=getNumComments($story['post_id'])?> Comments</a>
      </div>
  </footer>
        <?php
}

function draw_story($story, $comments_on)
{

  $upvote = "v0";
  $downvote = "v0";
  if (isset($_SESSION['username'])) {  
    $vote = postVoted(getUserId($_SESSION['username']), $story['post_id']);
      switch($vote['vote']){
        case -1:
          $downvote = "v1";
          break;
        case 1:
          $upvote = "v1";
          break;
      }
  }
    ?>
  <article class="story" id="p<?=$story['post_id']?>">
    <div class="post">
      <div class="flex-container-3">
        <div style= "order: 4" class="title">
          <header><a href="../pages/story.php?id=<?=$story['post_id']?>"><?=htmlentities($story['post_title'])?></a></header>
        </div>        
        <div style= "order: 1" class="vote" id="<?=$upvote?>">
            <button name="upvote"> <i class="fas fa-chevron-up"></i> </button>
            <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
            <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
            <input type="hidden" name="type" value="upvote">
        </div>
        <div style= "order: 3" class="vote" id="<?=$downvote?>">
            <button name="downvote">  <i class="fas fa-chevron-down"></i> </button>
            <input type="hidden" name="post_op" value="<?=$story['post_op']?>">
            <input type="hidden" name="post_id" value="<?=$story['post_id']?>">
            <input type="hidden" name="type" value="downvote">
        </div>
        <div style= "order: 2" class="vote-amount">
          <p><?=getVotes($story['post_id']) ?></p> 
        </div> 
      </div>
      <?php
      if($story['post_img'] == 9)
        draw_story_text($story);
      else
        draw_story_img($story);
      ?>
      <div class="flex-container-2">
        <ul>
          <?php
            draw_tags($story['post_id']); ?>
        </ul>
        <?php draw_story_footer($story); ?>
      </div>
      </div>
      <div class="comments">
        <?php if ($comments_on) {
                 draw_comment_form($story);
                 }?>
        <ol>
          <?php
                draw_comments($story['story_comments']); ?>
        </ol>
    </div>
  </article>
<?php
}

function draw_story_text($story)
{
    ?>
  <div class="storytext">
      <p><?php
          $filtered = htmlspecialchars($story['post_text']);
    $links_on = preg_replace("/\[([0-9a-zA-Z ]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/", "<a href=\"$2\">$1</a>", $filtered);
    $user_tags_on = preg_replace_callback("/\/u\/([a-zA-Z0-9]*)/", "getUserLink", $links_on);
    echo preg_replace_callback("/\/c\/([a-zA-Z0-9]*)/", "getChannelLink", $user_tags_on); ?></p>
  </div>
    <?php
}
  
  function draw_story_img($story)
  {
      ?>
    <div class="storyimg">
        <img src="../images/originals/<?=$story['post_img']?>.jpg">
    </div>
      <?php
  }
  

function draw_comment_form($post)
{
    ?>
  <section id="addComment">
    <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
    <textarea placeholder="Add a comment" required rows="4" cols="40"></textarea>
    <input type="submit" value="submit">
  </section> <?php
}

function draw_tags($story_id)
{
    $tags = getStoryTags($story_id);

    foreach ($tags as $tag) {
        ?>
    <li><a href="search.php?search_text=%23<?=$tag['tag_text']?>&search_type=stories&submit=Search"><?=$tag['tag_text']?></a></li>
    <?php
    }
}

function getUserLink($matches)
{
    $id = getUserId($matches[1]);
    return "<a href=\"profile.php?id=$id\">$matches[0]</a>";
}

function getChannelLink($matches)
{
    $id = getChannelId($matches[1]);
    return "<a href=\"channel.php?id=$id\">$matches[0]</a>";
}

function draw_comment($comment, $form = true, $display_children = true)
{
  $upvote = "v0";
  $downvote = "v0";
  if (isset($_SESSION['username'])) {  
    $vote = postVoted(getUserId($_SESSION['username']), $comment['post_id']);
      switch($vote['vote']){
        case -1:
          $downvote = "v1";
          break;
        case 1:
          $upvote = "v1";
          break;
      }
  }

    $children = getChildComments($comment['post_id']); ?>
   
<article class="parent-comment" id="p<?=$comment['post_id']?>"> 
  <div class="flex-container-1">  
      <div class="hide-comments"><button onclick="toggleCommentDisplay(p<?=$comment['post_id']?>)"><i class="far fa-minus-square"></i></button>
      </div>    
      <div style= "order: 2" class="vote-amount">
        <p><?=getVotes($comment['post_id']) ?></p>
      </div>  
      <div style= "order: 1" class="vote" id="<?=$upvote?>">
          <button name="upvote"> <i class="fas fa-chevron-up"></i> </button>
          <input type="hidden" name="post_op" value="<?=$comment['post_op']?>">
          <input type="hidden" name="post_id" value="<?=$comment['post_id']?>">
          <input type="hidden" name="type" value="upvote">
      </div>
      <div style= "order: 3" class="vote" id="<?=$downvote?>">  
          <button name="downvote">  <i class="fas fa-chevron-down"></i> </button>
          <input type="hidden" name="post_op" value="<?=$comment['post_op']?>">
          <input type="hidden" name="post_id" value="<?=$comment['post_id']?>">
          <input type="hidden" name="type" value="downvote">
      </div>
      <div style= "order: 4" class="comment-op">  
        <p><?=getUserName($comment['post_op'])?></p>
      </div>
    </div>
    <div class = "comment-text"> 
    <p> <?php
            $filtered = htmlspecialchars($comment['post_text']);
    $links_on = preg_replace("/\[([0-9a-zA-Z ]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/", "<a href=\"$2\">$1</a>", $filtered);
    $user_tags_on = preg_replace_callback("/\/u\/([a-zA-Z0-9]*)/", "getUserLink", $links_on);
    echo preg_replace_callback("/\/c\/([a-zA-Z0-9]*)/", "getChannelLink", $user_tags_on); ?></p>
            <div class="submitted-comment">
              Submitted by: <a href="profile.php?id=<?=$comment['post_op']?>"><?=getUserName($comment['post_op'])?></a> on <?=$comment['post_date']?> 
            </div>
    </div>
  <?php
    if ($form) {
        draw_comment_form($comment);
    } 
    
    if($display_children){

    ?>
      <ol>
  <?php draw_comments($children, $form, $display_children); ?>
      </ol>
    <?php }?>
</article> 
    </li>
  <?php
}
      
function draw_comments($comments, $form = true, $display_children = true)
{
    foreach ($comments as $comment) {
        draw_comment($comment, $form, $display_children);
    }
}


function draw_text_story_adder()
{
    ?>
    <article class="new-element" style="display:none;" id="text-story">
      <form name="text-story" action="../actions/action_add_story.php" method="post">
      <div class="choice-select" style="width:200px;"> 
            <select name="channel_id" required> <?php
              draw_select_channels(getAllChannels()); ?>
            </select>
        </div>
          <input type="text" name="story_title" placeholder="Add story">
          <textarea rows="4" cols="50" name="story_text" placeholder="What is on your mind?"></textarea>
          </div>
          <div class="tags">
             <?php
            draw_select_tags(getAllTags()); ?>
          </div>
          <input type="submit" value="Submit">
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
      </form>
    </article>
  <?php
}

function draw_img_story_adder()
{
    ?>
 <article class="new-element" style="display:none;" id="image-story">
    <form name="img-story" action="../actions/action_add_story.php" method="post" enctype="multipart/form-data">
    <div class="choice-select" style="width:200px;"> 
          <select name="channel_id" required> <?php
            draw_select_channels(getAllChannels()); ?>
          </select>
      </div>
        <input type="text" name="story_title" placeholder="Add story">
        <input type="file" name="image" id="file" class="inputfile" >
         <label for="file"><i class="fas fa-upload"></i> Choose a file</label>
        </div>
        <div class="tags"> <?php
          draw_select_tags(getAllTags()); ?>
        </div>
        <input type="submit" value="Submit">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
</article>
<?php
}

function draw_new_story_buttons()
{
    ?>
    <div id="new-story">
        <input type="button" value = "Text story">
        <input type="button" value = "Image story">
    </div>
  <?php
}
