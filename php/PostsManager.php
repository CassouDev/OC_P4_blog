<?php
require('Posts.php');

class PostsManager
{
  private $_db; // Instance de PDO.

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function getPosts()
  {
    $postsArray = [];
    
    $req = $this->_db->query("SELECT id, chapter, title, content, DATE_FORMAT(postDate, '%d/%m/%Y') AS postDate FROM posts ORDER BY chapter DESC");
    while($postsData = $req->fetch())
    {
      $postsArray[] = new Posts($postsData);
    }
    
    return $postsArray;
  }

  public function getOnePost()
  {
    $onePostArray = [];

    $req = $this->_db->prepare("SELECT id, chapter, title, content, DATE_FORMAT(postDate, '%d/%m/%Y') AS postDate FROM posts WHERE chapter = :chapter");
    $req->execute([
        "chapter"=> $_GET['chapterNb']
    ]);

    while($OnePostData = $req->fetch())
    {
      $onePostArray[] = new Posts($OnePostData);
    }

    return $onePostArray;
  }

  public function countPosts()
  {   
    return $this->_db->query('SELECT COUNT(*) AS postsNb FROM posts')->fetch();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
