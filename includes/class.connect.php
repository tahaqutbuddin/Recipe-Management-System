<?php
require_once "config.php";
  class dbConnect 
  {
      function connect() 
      {
            try 
            {
              $this->conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE.";charset=utf8", USER ,PASSWORD,array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
              ));
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $pe) 
            {
                die("Could not connect to the database ".DATABASE." :" . $pe->getMessage());
            }   
          return $this->conn;  
      }  
      public function Close(){  
          $this->conn = null;
      }  
  }  
?>