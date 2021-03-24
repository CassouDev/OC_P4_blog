<?php
require('Post.php');

class PostManager
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

  public function getPost()
  {
    $postsArray = [];
    
    $req = $this->_db->prepare("SELECT id, chapter, title, content, DATE_FORMAT(postDate, '%d/%m/%Y') AS postDate FROM posts ORDER BY chapter DESC");
    $req->execute();

    while($postsData = $req->fetch())
    {
      $postsArray[] = new Post($postsData);
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
      $onePostArray[] = new Post($OnePostData);
    }

    return $onePostArray;
  }

  public function addPosts(Post $newPost)
  {
    $insertReq = $this->_db->prepare("INSERT INTO posts(chapter, title, postDate, content) VALUES(:chapter, :title, NOW(), :content)");
    $insertReq->execute(array(
      'chapter' => $newPost->chapter(), 
      'title' => $newPost->title(),
      'content' => $newPost->content()
    ));
  }

  public function editPost()
  {
    $editReq = $this->_db->prepare('UPDATE posts SET title = :nwTitle, content = :nwContent WHERE chapter = :chapter');
    $editReq->execute(array(
      'nwTitle'=>$_POST['title'], 
      'nwContent'=>$_POST['content'], 
      'chapter'=> $_GET['chapterNb']
    ));
  }

  public function deletePost()
  {
    $delete = $this->_db->prepare("DELETE FROM posts WHERE chapter = :chapter");
    $delete->execute([
        'chapter' => $_GET['chapterNb']
    ]);
  }

  public function countPosts()
  {   
    $countReq = $this->_db->prepare('SELECT COUNT(*) AS postsNb FROM posts');
    $countReq->execute();

    return $countReq->fetchColumn();
  }

  public function getTitles($chapter)
  {
    $title = [];

    $titleReq= $this->_db->prepare('SELECT title FROM posts WHERE chapter = :chapter');
    $titleReq->execute([
        'chapter'=> $chapter
    ]);

    while ($titleData = $titleReq->fetch())
    {
      $title[] = new Post($titleData);
    }

    return $title;
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
