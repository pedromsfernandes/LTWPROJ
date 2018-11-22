<?php
    include_once('../includes/database.php');

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

    function getChannel($channel_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM channel WHERE channel_id = ?');
        $stmt->execute(array($channel_id));
        return $stmt->fetch();
    }
?>
