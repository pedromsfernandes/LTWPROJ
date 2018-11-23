<?php
  include_once('../includes/database.php');

  function getUserComments($username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM comment WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetchAll();
  }

  function searchComments($pattern)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM comment WHERE cmt_text LIKE ?');
      $stmt->execute(array("%$pattern%"));
      return $stmt->fetchAll();
  }

    /**
   * Inserts a new comment into a story.
   */
  function insertComment($comment_text, $story_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO comment VALUES(NULL, ?, datetime('now'), 0, NULL, ?, ?)");
      $stmt->execute(array($comment_text, $story_id, $username));
  }

  function getCommentVotes($cmt_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as numEntries FROM vote_comment WHERE cmt_id = ?");
    $stmt->execute(array($cmt_id));
    $res = $stmt->fetch()['numEntries'];

    if($res == 0)
        return 0;

    $stmt = $db->prepare("SELECT SUM(vote) as numVotes FROM vote_comment WHERE cmt_id = ?");
    $stmt->execute(array($cmt_id));
    return $stmt->fetch()['numVotes'];
  }

  function addCommentVote($cmt_id, $username, $vote)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO vote_comment VALUES(?, ?, ?)");
      $stmt->execute(array($cmt_id, $username, $vote));
  }

    function remCommentVote($cmt_id, $username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("DELETE FROM vote_comment WHERE cmt_id = ? AND username = ?");
        $stmt->execute(array($cmt_id, $username));
    }

    function lastCommentVote($username, $cmt_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT vote FROM vote_comment WHERE username = ? AND cmt_id = ?');
        $stmt->execute(array($username, $cmt_id));
        return $stmt->fetch()['vote'];
    }
  ?>