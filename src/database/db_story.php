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
  function insertStory($story_title, $story_text, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO story VALUES(NULL, ?, ?, datetime('now'), 0, ?)");
      $stmt->execute(array($story_title, $story_text, $username));
  }

  /**
   * Inserts a new comment into a story.
   */
  function insertComment($comment_text, $story_id, $username)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO comment VALUES(NULL, ?, strtotime('now'), 0, NULL, ?, ?)");
      $stmt->execute(array($comment_text, $story_id, $username));
  }
