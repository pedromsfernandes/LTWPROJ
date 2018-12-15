<?php
  include_once('../includes/session.php');
  include_once('../database/db_comment.php');
  include_once('../database/db_user.php');
  include_once('../database/db_post.php');
  include_once('../templates/tpl_stories.php');
  include_once('../includes/database.php');

  // Verify if user is logged in
  if (!isset($_SESSION['username'])) {    
      $answer = 'reject_log';
  } else {
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['cmt_text'];
    $user_id = getUserId($_SESSION['username']);

    $new_id = insertComment($comment_text, $post_id, $user_id);

    $votes = getVotes($post_id);

    $filtered = htmlspecialchars($comment_text);
    $links_on = preg_replace("/\[([0-9a-zA-Z ]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/","<a href=\"$2\">$1</a>",$filtered);
    $user_tags_on = preg_replace_callback("/\/u\/([a-zA-Z0-9]*)/","getUserLink",$links_on);
    $text = preg_replace_callback("/\/c\/([a-zA-Z0-9]*)/","getChannelLink",$user_tags_on);

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT datetime('now') as date");
    $stmt->execute();
    $date = $stmt->fetch();

    $upvote = 0;
    $downvote = 0;
    $vote = postVoted($user_id, $new_id['post_id']);
    switch($vote['vote']){
        case -1:
            $downvote = 1;
            break;
        case 1:
            $upvote = 1;
            break;
    }

    $answer = [$post_id, $text, $votes, $user_id, $_SESSION['username'], $date, $new_id, $upvote, $downvote];
  }

  echo json_encode($answer);
