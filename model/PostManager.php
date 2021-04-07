<?php
require('Post.php');
require_once('Database.php');

class PostManager extends Database
{
  public function __construct()
  {
    $this->_db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
    // $this->_db = new PDO('mysql:host=db5001825346.hosting-data.io;dbname=dbs1502331;charset=utf8', 'dbu969252', 'Anima-2012');
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

    $req = $this->_db->prepare("SELECT id, chapter, title, content, DATE_FORMAT(postDate, '%d/%m/%Y') AS postDate FROM posts WHERE id = :id");
    $req->execute([
        "id"=> $_GET['chapterId']
    ]);

    while($OnePostData = $req->fetch())
    {
      $onePostArray[] = new Post($OnePostData);
    }

    return $onePostArray;
  }

  public function getPostId($chapter)
  {
    $postId = [];
    
    $req = $this->_db->prepare("SELECT * FROM posts WHERE chapter = :chapter");
    $req->execute([
        "chapter"=> $chapter
    ]);

    while($postData = $req->fetch())
    {
      $postId[] = new Post($postData);
    }

    return $postId;
  }

  public function getTitles($postId)
  {
    $title = [];

    $titleReq= $this->_db->prepare('SELECT title, chapter FROM posts WHERE id = :id');
    $titleReq->execute([
        'id'=> $postId
    ]);

    while ($titleData = $titleReq->fetch())
    {
      $title[] = new Post($titleData);
    }

    return $title;
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
    $editReq = $this->_db->prepare('UPDATE posts SET title = :nwTitle, content = :nwContent, postDate = NOW() WHERE id = :id');
    $editReq->execute(array(
      'nwTitle'=>$_POST['title'], 
      'nwContent'=>$_POST['content'], 
      'id'=> $_GET['chapterId']
    ));
  }

  public function deletePost()
  {
    $delete = $this->_db->prepare("DELETE FROM posts WHERE id = :id");
    $delete->execute([
        'id' => $_GET['chapterId']
    ]);
  }

  public function countPosts()
  {   
    $countReq = $this->_db->prepare('SELECT COUNT(*) AS postsNb FROM posts');
    $countReq->execute();

    return $countReq->fetchColumn();
  }
}
