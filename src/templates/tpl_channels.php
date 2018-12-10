<?php function draw_channels($channels){
    ?>
<ul>
<?php
    foreach ($channels as $channel) {
        ?>
    <li><a href="../pages/channel.php?id="<?=$channel['channel_id']?>><?=$channel['channel_name']?></a></li>
<?php
    } ?>
</ul>
    <?php
}

function draw_channel_info($channel){

    $id = $channel['channel_id'];
    ?>
  <section id="channelInfo">
    <form method="post">
      <div class="channel-flexbox">
        <?php
          if($_SESSION['username']){
        ?>
        <button name="subscribe">
        <?php
          if(isUserSubscribed($id, getUserId($_SESSION['username'])))
            echo 'Unsubscribe';
          else
            echo 'Subscribe';
        ?>
        </button>
        <?php
        }
        ?>
        <input type="hidden" name="channel_id" value="<?=$id?>">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
        <div class="channel">
          <?=$channel['channel_name']?>
        </div>
        <img src="../images/originals/<?=$channel['channel_header']?>.jpg" width="800" height="400">
        <div class="subscribers">
          Subscribers: <?=getNumSubscribers($id)?>
        </div>
    </div>
  </section>

<?php
}
function draw_channel_adder(){ ?>
<article class="new-element">
    <form action="../actions/action_add_channel.php" method="post" enctype="multipart/form-data">
      <input type="text" name="channel_name" placeholder="Channel name">
      <input type="textarea" name="channel_description" placeholder="What is the channel for?">
      <input type="file" name="image">
      <input type="submit" value="Submit">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
</article>
<?php
}