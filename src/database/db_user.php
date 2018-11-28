<?php
  include_once('../includes/database.php');

  /**
   * Verifies if a certain username, password combination
   * exists in the database. Use the sha1 hashing function.
   */
    function checkUserPassword($username, $password)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM user WHERE user_name = ? AND user_pass = ?');
        $stmt->execute(array($username, sha1($password)));
        return $stmt->fetch()?true:false; // return true if a line exists
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
        $default_avatar = 'http://a.wordpress.com/avatar/unknown-128.jpg';
        $db = Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO user VALUES(NULL, ?, ?, NULL, ?, 0)");
        $stmt->execute(array($username, sha1($password), $default_avatar));
    }

    function editProfile($new_username, $username, $password, $description, $avatar)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE user SET user_name = ?, user_pass = ?, user_description = ?, user_avatar = ? WHERE user_name = ?');
        $stmt->execute(array($new_username, sha1($password), $description, $avatar, $username));
    }

    function getProfile($user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT user_name, user_description, user_avatar, user_points FROM user WHERE user_id = ?');
        $stmt->execute(array($user_id));
        return $stmt->fetch();
    }

    function addPoint($username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("UPDATE user SET user_points = user_points + 1 WHERE user_name = ?");
        $stmt->execute(array($username));
    }
      
    function remPoint($username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("UPDATE user SET user_points = user_points - 1 WHERE user_name = ?");
        $stmt->execute(array($username));
    }
