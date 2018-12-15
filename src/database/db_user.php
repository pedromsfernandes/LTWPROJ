<?php
    include_once('../includes/database.php');

    /**
     * Verifies if a certain username, password combination
     * exists in the database. Use the sha1 hashing function.
     */
    function checkUserPassword($username, $password)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM user WHERE user_name = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch(); // return true if a line exists

        if ($user !== false && password_verify($password, $user['user_pass']))
            return true;
        return false;
    }

    function usernameExists($username){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM user WHERE user_name = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch(); // return true if a line exists

        return $user !== false;
    }

    function getUserId($username){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT user_id FROM user WHERE user_name = ?');
        $stmt->execute(array($username));
        return $stmt->fetch()['user_id'];
    }

    function getUserName($user_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT user_name FROM user WHERE user_id = ?');
        $stmt->execute(array($user_id));
        return $stmt->fetch()['user_name'];
    }

    function insertUser($username, $password)
    {
        $options = ['cost' => 12];
        $db = Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO user VALUES(NULL, ?, ?, NULL, 0, ?)");
        $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), 8));
    }

    function editProfile($username, $description, $avatar)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE user SET user_description = ?, user_avatar = ? WHERE user_name = ?');
        $stmt->execute(array($description, $avatar, $username));
    }

    function getProfile($user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT user_name, user_description, user_avatar, user_points FROM user WHERE user_id = ?');
        $stmt->execute(array($user_id));
        return $stmt->fetch();
    }

    function getSubscribedStories($user_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE channel_id IN (SELECT channel_id FROM subscription WHERE user_id = ?)');
        $stmt->execute(array($user_id));
        return $stmt->fetchAll();
    }

    function getSubscribedStoriesByVotes($user_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * from (SELECT * FROM 
                            post JOIN (SELECT vote.post_id, SUM(vote.vote) AS num_votes
                                FROM vote GROUP BY vote.post_id UNION 
                                SELECT post_id, 0 FROM post 
                                WHERE post_id NOT IN (SELECT post_id FROM vote)) 
                            USING(post_id) WHERE post_title IS NOT NULL ORDER BY num_votes DESC, post_date DESC) this 
                            WHERE channel_id IN (SELECT channel_id FROM subscription WHERE user_id = ?)");
        $stmt->execute(array($user_id));
        return $stmt->fetchAll();
    }

    function getSubscribedStoriesByComments($user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM 
                            post JOIN (SELECT post_father AS post_id, COUNT(*) as numComments FROM post GROUP BY post_father UNION 
                                SELECT post_id, 0 FROM post 
                                WHERE post_id NOT IN (SELECT post_father FROM post WHERE post_father IS NOT NULL)) 
                            USING(post_id) WHERE channel_id IN (SELECT channel_id FROM subscription WHERE user_id = ?) 
                            AND post_title IS NOT NULL ORDER BY numComments DESC, post_date DESC");
        $stmt->execute(array($user_id));
        return $stmt->fetchAll();
    }
    
   function getSubscribedChannels($user_id)
   {
       $db = Database::instance()->db();
       $stmt = $db->prepare('SELECT * FROM channel WHERE channel_id IN (SELECT channel_id FROM subscription WHERE user_id = ?)');
       $stmt->execute(array($user_id));
       return $stmt->fetchAll();
   }
