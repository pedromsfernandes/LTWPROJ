<?php
  /**
   * A singleton representing the app connection
   * to the database. Use Database::instance() to
   * access it and db() to get the database connection.
   */
  class Database
  {
      private static $instance = null;
      private $db = null;
    
      /**
       * Private constructor. Creates a database connection.
       * Sets fetch mode to fetch using associative arrays
       * and turns on exceptions. Also turns on foreign keys
       * enforcement.
       */
      private function __construct()
      {
          $this->db = new PDO('sqlite:../database/shareit.db');
          $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->db->query('PRAGMA foreign_keys = ON');
          if (null == $this->db) {
              throw new Exception("Failed to open database");
          }
      }

      /**
       * Returns the database connection.
       */
      public function db()
      {
          return $this->db;
      }

      /**
       * Returns this singleton instance. Creates it if needed.
       */
      public static function instance()
      {
          if (null == self::$instance) {
              self::$instance = new Database();
          }
          return self::$instance;
      }
  }
