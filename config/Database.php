<?php

class Database
{
  // DB 관련 매개변수
  private $host = 'localhost';
  private $dbName = 'myblog';
  private $username = 'root';
  private $password = '';
  private $conn;

  // DB Connect
  public function connect()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn;
  }
}
