<?php
require('User.php');

class UserManager
{
  private $_db; // Instance de PDO.

  public function __construct()
  {
    try 
    {
      $this->_db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
      // $this->_db = new PDO('mysql:host=db5001825346.hosting-data.io;dbname=dbs1502331;charset=utf8', 'dbu969252', 'Anima-2012');
    }
    catch (Exception $e) 
    {
      die('Erreur : ' . $e->getMessage());
    }
  }

  public function getUserPseudo()
  {
    $pseudoReq = $this->_db->prepare('SELECT pseudo FROM users');
    $pseudoReq->execute();

    return $pseudoReq->fetchColumn();
  }

  public function getPassFromUser()
  {
    $userReq = $this->_db->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
    $userReq->execute(array(
      'pseudo' => $_GET['pseudo']
    ));
    $userData = $userReq->fetch();

    return new User($userData);
  }

  // public function getUser()
  // {
  //   $userReq = $this->_db->prepare('SELECT * FROM users');
  //   $userReq->execute();

  //   $userData = $userReq->fetch();

  //   // return new User($userData);
  // }

  // public function getUserIdFromPseudo()
  // {
  //   $userIdReq = $this->_db->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
  //   $userIdReq->execute(array(
  //     'pseudo' => $_GET['pseudo']
  //   ));
  //   $userIdData = $userIdReq->fetch();
  //   // var_dump(new User($userData));
    
  //   return new User($userIdData);
  // }

  public function addUser(User $newUser)
  {
    // Hachage du mot de passe
    $pass_hache = password_hash($newUser->pass(), PASSWORD_DEFAULT);

    $addUserReq = $this->_db->prepare('INSERT INTO users(pseudo, pass) VALUES(:pseudo, :pass)');
    $addUserReq->execute(array(
      'pseudo' => $newUser->pseudo(),
      'pass' => $pass_hache
    ));
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}