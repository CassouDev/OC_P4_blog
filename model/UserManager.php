<?php
require('User.php');
require_once('Database.php');

class UserManager extends Database
{
  public function __construct()
  {
    $this->_db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
    // $this->_db = new PDO('mysql:host=db5001825346.hosting-data.io;dbname=dbs1502331;charset=utf8', 'dbu969252', 'Anima-2012');
  }
  
  public function getUserPseudo()
  {
    $pseudoReq = $this->_db->prepare('SELECT pseudo FROM users');
    $pseudoReq->execute();

    return $pseudoReq->fetchColumn();
  }

  public function getPassFromUser()
  {
    $userReq = $this->_db->prepare('SELECT id, pass  FROM users WHERE pseudo = :pseudo');
    $userReq->execute(array(
      'pseudo' => $_POST['pseudo']
    ));
    $userData = $userReq->fetch();

    return new User($userData);
  }

  // public function addUser(User $newUser)
  // {
  //   // Hachage du mot de passe
  //   $pass_hache = password_hash($newUser->pass(), PASSWORD_DEFAULT);

  //   $addUserReq = $this->_db->prepare('INSERT INTO users(pseudo, pass) VALUES(:pseudo, :pass)');
  //   $addUserReq->execute(array(
  //     'pseudo' => $newUser->pseudo(),
  //     'pass' => $pass_hache
  //   ));
  // }

  public function addJeanForteroche()
  {
    // Hachage du mot de passe
    $pass_hache = password_hash('Wadji', PASSWORD_DEFAULT);

    $addUserReq = $this->_db->prepare('INSERT INTO users(pseudo, pass) VALUES(Jean_Forteroche, :pass)');
    $addUserReq->execute(array(
      'pass' => $pass_hache
    ));
  }
}