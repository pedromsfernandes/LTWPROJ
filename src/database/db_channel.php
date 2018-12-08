<?php
    include_once('../includes/database.php');

    function addSubscription($channel_id, $user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO subscription VALUES(?, ?)');
        $stmt->execute(array($channel_id, $user_id));
    }
    
    function searchChannels($pattern){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM channel WHERE channel_name LIKE ? OR channel_desc LIKE ?');
        $stmt->execute(array("%$pattern%", "%$pattern%"));
        return $stmt->fetchAll();
    }

    function removeSubscription($channel_id, $user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('DELETE FROM subscription WHERE channel_id = ? AND user_id = ?');
        $stmt->execute(array($channel_id, $user_id));
    }

    function isUserSubscribed($channel_id, $user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM subscription WHERE channel_id = ? AND user_id = ?');
        $stmt->execute(array($channel_id, $user_id));
        return $stmt->fetch() ? true : false;
    }

    function insertChannel($channel_name, $channel_description, $user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO channel VALUES(NULL, ?, ?, ?)');
        $stmt->execute(array($channel_name, $channel_description, $user_id));

        $stmt = $db->prepare('SELECT MAX(channel_id) AS channel_id FROM channel');
        $stmt->execute();

        return $stmt->fetch()['channel_id'];
    }

    function getChannel($channel_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM channel WHERE channel_id = ?');
        $stmt->execute(array($channel_id));
        return $stmt->fetch();
    }

    function getChannelId($channel_name)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM channel WHERE channel_name = ?');
        $stmt->execute(array($channel_name));
        return $stmt->fetch()['channel_id'];
    }

    function getAllChannels()
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM channel');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getNumSubscribers($channel_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT COUNT(*) as numSubscribers FROM subscription GROUP BY channel_id HAVING channel_id = ?');
        $stmt->execute(array($channel_id));
        $res = $stmt->fetch()['numSubscribers'];

        return $res == 0 ? 0 : $res;
    }
?>
