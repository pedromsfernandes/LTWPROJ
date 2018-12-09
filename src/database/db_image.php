<?php
  include_once('../includes/database.php');

  function insertImage(){
    $db = Database::instance()->db();
    $stmt = $db->prepare("INSERT INTO image VALUES(NULL)");
    $stmt->execute();
  }

  function getImage($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM image WHERE img_id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
  }