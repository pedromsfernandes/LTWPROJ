<?php
  include_once('../includes/database.php');

  function getUserStories($username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM story WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetchAll();
  }

  function getAllStories($order = "story_date", $asc_desc = "DESC")
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("SELECT * FROM story ORDER BY $order $asc_desc");
      $stmt->execute();
      return $stmt->fetchAll();
  }

    function getChannelStories($channel, $order = "story_date", $asc_desc = "DESC")
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM story WHERE channel_id = ? ORDER BY $order $asc_desc");
        $stmt->execute(array($channel));
        return $stmt->fetchAll();
    }

  function getStory($story_id)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM story WHERE story_id = ?');
      $stmt->execute(array($story_id));
      return $stmt->fetch();
  }


  function getStoryComments($story_id)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM comment WHERE story_id = ?');
      $stmt->execute(array($story_id));
      return $stmt->fetchAll();
  }

    function searchStories($pattern)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM story WHERE story_title LIKE ? OR story_text LIKE ?');
        $stmt->execute(array("%$pattern%", "%$pattern%"));
        return $stmt->fetchAll();
    }

   /**
   * Inserts a new story into the database.
   */
  function insertStory($story_title, $story_text, $channel_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO story VALUES(NULL, ?, ?, datetime('now'), 0, ?, ?)");
      $stmt->execute(array($story_title, $story_text, $channel_id, $username));
  }

  function addVote($story_id, $username, $vote)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO vote_story VALUES(?, ?, ?)");
      $stmt->execute(array($story_id, $username, $vote));
  }

  function getStoryVotes($story_id){
        $db = Database::instance()->db();
      $stmt = $db->prepare("SELECT COUNT(*) as numVotes FROM vote_story WHERE story_id = ?");
      $stmt->execute(array($story_id));
    return $stmt->fetch();
  }
  
  function remVote($story_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("DELETE FROM vote_story WHERE story_id = ? AND username = ?");
      $stmt->execute(array($story_id, $username));
  }

    function lastVote($username, $story_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT vote FROM vote_story WHERE username = ? AND story_id = ?');
        $stmt->execute(array($username, $story_id));
        return $stmt->fetch()['vote'];
    }

    function hasUpvoted($username, $story_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM vote WHERE username = ? AND story_id = ?');
        $stmt->execute(array($username, $story_id));
        $res = $stmt->fetch();
        print_r($res);
        return $res['vote'] == 1;
    }

    function hasDownvoted($username, $story_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM vote WHERE username = ? AND story_id = ?');
        $stmt->execute(array($username, $story_id));
        $res = $stmt->fetch();
        return $res['vote'] == -1;
    }

