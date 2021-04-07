<?php
class Database
{
  private $_db; // Instance de PDO.

  public function __construc($db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
