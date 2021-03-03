<?php
require('Comments.php');

class CommentsManager 
{
    private $_db; // Instance de PDO.

    public function __construct($db)
    {
      $this->setDb($db);
    }

    public function getComments()
    {
        $commentArray = [];
        
        $commentReq = $this->_db->prepare("SELECT id, postChapter, pseudo, comment, DATE_FORMAT(commentDate, '%d/%m/%Y') AS commentDate, reportComment FROM comments WHERE postChapter = ? AND reportComment = '0' ORDER BY id DESC");
        $commentReq->execute([
            $_GET['chapterNb']
        ]);

        while ($commentData = $commentReq->fetch()) 
        {
            $commentArray[] = new Comments($commentData);
        }
        
        return $commentArray;
    }

    public function countComments()
    {   
        $numberCoReq = $this->_db->prepare("SELECT COUNT(*) AS commentNumber FROM comments WHERE postChapter = ? AND reportComment = '0'");
        $numberCoReq->execute([
            $_GET['chapterNb']
        ]);

        return $numberCoReq->fetchColumn();
    }

    public function addComments()
    {
        $postChapter = $_GET['chapterNb'];
        $pseudo = $_POST['pseudo'];
        $comment = $_POST['comment'];
        $report = '0';
            
        $insertReq = $this->_db->prepare('INSERT INTO comments(postChapter, pseudo, comment, commentDate, reportComment) VALUES(:postChapter, :pseudo, :comment, NOW(), :report)');
        $insertReq->execute(array(
            'postChapter' => $postChapter,
            'pseudo' => $pseudo,
            'comment' => $comment,
            'report' => $report
        ));
    }

    public function reportComments()
    {
        $reportReq = $this->_db->prepare('UPDATE comments SET reportComment = 1 WHERE id = :commentId');
        $reportReq->execute([
        'commentId' => $_GET['id']
        ]);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}