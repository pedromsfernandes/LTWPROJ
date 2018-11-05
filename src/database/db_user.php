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
        $default_avatar = 'http://a.wordpress.com/avatar/unknown-128.jpg';
        $db = Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO user VALUES(?, ?, NULL, ?, NULL)");
        $stmt->execute(array($username, sha1($password), $default_avatar));
    }

    function editProfile($new_username, $username, $password, $description, $avatar)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE user SET username = ?, password = ?, description = ?, avatar = ? WHERE username = ?');
        $stmt->execute(array($new_username, sha1($password), $description, $avatar, $username));
    }

    function getProfile($username)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT username, description, avatar, points FROM user WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function addPoint($username)
        {
              $db = Database::instance()->db();
              $stmt = $db->prepare("UPDATE user SET points = points + 1 WHERE username = ?");
              $stmt->execute(array($username));
        }
      
        
        function remPoint($username)
          {
                $db = Database::instance()->db();
                $stmt = $db->prepare("UPDATE user SET points = points - 1 WHERE username = ?");
                $stmt->execute(array($username));
          }
