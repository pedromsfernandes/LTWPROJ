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

  ?>