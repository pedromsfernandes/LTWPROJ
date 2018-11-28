<?php
  include_once('../includes/database.php');

  function getUserComments($user_id)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM post WHERE post_op = ? AND post_father IS NOT NULL');
      $stmt->execute(array($user_id));
      return $stmt->fetchAll();
  }

  function searchComments($pattern)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM post WHERE post_text LIKE ? AND post_father IS NOT NULL');
      $stmt->execute(array("%$pattern%"));
      return $stmt->fetchAll();
  }

    /**
   * Inserts a new comment into a story.
   */
  function insertComment($comment_text, $story_id, $user_id)
  {
      $db = Database::instance()->db();
      $stmt = $db->prepare("INSERT INTO post VALUES(NULL, NULL, ?, datetime('now'), ?, ?, NULL)");
      $stmt->execute(array($comment_text, $user_id, $story_id));
  }
  ?>