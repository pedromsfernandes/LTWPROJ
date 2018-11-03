<?php
  include_once('../includes/database.php');

  /**
   * Verifies if a certain username, password combination
   * exists in the database. Use the sha1 hashing function.
   */
    function checkUserPassword($username, $password)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM user WHERE username = ? AND password = ?');
        $stmt->execute(array($username, sha1($password)));
        return $stmt->fetch()?true:false; // return true if a line exists
    }

    function insertUser($username, $password)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO user VALUES(?, ?, NULL, NULL, NULL)');
        $stmt->execute(array($username, sha1($password)));
    }

    function editAttribute($username, $attribute, $value)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE user SET ? = ? WHERE username = ?');
        $stmt->execute(array($attribute, $value, $username));
    }

    function getProfile($username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT username, description, avatar, points FROM user WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }
