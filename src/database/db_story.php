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

  function getUserComments($username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM comment WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetchAll();
  }

    function searchStories($pattern)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM story WHERE story_title LIKE ? OR story_text LIKE ?');
        $stmt->execute(array("%$pattern%", "%$pattern%"));
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
   * Inserts a new story into the database.
   */
  function insertStory($story_title, $story_text, $channel_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO story VALUES(NULL, ?, ?, datetime('now'), 0, ?, ?)");
      $stmt->execute(array($story_title, $story_text, $channel_id, $username));
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

  function addVote($story_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO vote VALUES(?, ?, 1)");
      $stmt->execute(array($story_id, $username));
  }

  function getStoryVotes($story_id){
        $db = Database::instance()->db();
      $stmt = $db->prepare("SELECT COUNT(*) as numVotes FROM vote WHERE story_id = ?");
      $stmt->execute(array($story_id));
    return $stmt->fetch();
  }

  
  function remVote($story_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO vote VALUES(?, ?, -1)");
      $stmt->execute(array($story_id, $username));
  }

  function getChannel($channel_id)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM channel WHERE channel_id = ?');
      $stmt->execute(array($channel_id));
      return $stmt->fetch();
  }

  function addSubscription($channel_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('INSERT INTO subscription VALUES(?, ?');
      $stmt->execute(array($channel_id, $username));
  }

    function insertChannel($channel_name, $channel_description, $username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO channel VALUES(NULL, ?, ?, ?');
        $stmt->execute(array($channel_name, $channel_description, $username));
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

