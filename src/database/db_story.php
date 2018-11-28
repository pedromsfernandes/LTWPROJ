<?php
    include_once('../includes/database.php');

    function getUserStories($user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_op = ? AND post_title IS NOT NULL');
        $stmt->execute(array($user_id));
        return $stmt->fetchAll();
    }

    function getAllStories($order = "post_date", $asc_desc = "DESC")
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM post WHERE post_title IS NOT NULL ORDER BY $order $asc_desc");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getChannelStories($channel, $order = "post_date", $asc_desc = "DESC")
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM post WHERE channel_id = ? AND post_title IS NOT NULL ORDER BY $order $asc_desc");
        $stmt->execute(array($channel));
        return $stmt->fetchAll();
    }

    function getStory($story_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_id = ? AND post_title IS NOT NULL');
        $stmt->execute(array($story_id));
        return $stmt->fetch();
    }

    function getStoryComments($story_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_father = ?');
        $stmt->execute(array($story_id));
        return $stmt->fetchAll();
    }

    function searchStories($pattern)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_title IS NOT NULL AND post_title LIKE ? OR post_text LIKE ?');
        $stmt->execute(array("%$pattern%", "%$pattern%"));
        return $stmt->fetchAll();
    }

   /**
   * Inserts a new story into the database.
   */
    function insertStory($story_title, $story_text, $user_id, $channel_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO post VALUES(NULL, ?, ?, datetime('now'), ?, NULL, ?)");
        $stmt->execute(array($story_title, $story_text, $user_id, $channel_id));
    }

