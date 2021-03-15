<?php
require('Comment.php');

class CommentManager 
{
    private $_db; // Instance de PDO.

    public function __construct($db)
    {
      $this->setDb($db);
    }

    public function addComments(Comment $newComment)
    {        
        $insertReq = $this->_db->prepare("INSERT INTO comments(postChapter, pseudo, comment, commentDate) VALUES(:postChapter, :pseudo, :comment, NOW())");
        $insertReq->execute(array(
            'postChapter' => $newComment->postChapter(),
            'pseudo' => $newComment->pseudo(),
            'comment' => $newComment->comment()
        ));
    }

    public function deleteCommentFromPost()
    {
        $deleteFromPostReq = $this->_db->prepare('DELETE FROM comments WHERE postChapter = :postChapter');
        $deleteFromPostReq->execute([
            'postChapter' => $_GET['chapterNb']
        ]);
    }

    public function deleteComment()
    {
        $deleteComment = $this->_db->prepare('DELETE FROM comments WHERE id = :id');
        $deleteComment->execute([
            'id'=>$_GET['id']
        ]);
    }

    public function getOnePostComments()
    {
        $OnePostComments = [];
        
        $postCmtReq = $this->_db->prepare("SELECT id, postChapter, pseudo, comment, DATE_FORMAT(commentDate, '%d/%m/%Y') AS commentDate, reportComment FROM comments WHERE postChapter = ? AND reportComment = '0' ORDER BY id DESC");
        $postCmtReq->execute([
            $_GET['chapterNb']
        ]);

        while ($postCmtData = $postCmtReq->fetch()) 
        {
            $OnePostComments[] = new Comment($postCmtData);
        }
        
        return $OnePostComments;
    }

    public function getUnreportedComments()
    {
        $unreportedCmt = [];

        $unreportedReq = $this->_db->query("SELECT id, postChapter, pseudo, comment, DATE_FORMAT(commentDate, '%d/%m/%Y') AS commentDate, reportComment FROM comments WHERE reportComment = '0' ORDER BY postChapter DESC");

        while ($unreportedData = $unreportedReq->fetch())
        {
            $unreportedCmt[] = new Comment($unreportedData);
        }

        return $unreportedCmt;
    }

    public function getReportedComments()
    {
        $reportedCmt = [];

        $reportedReq = $this->_db->query("SELECT * FROM comments WHERE  reportComment = '1' ORDER BY postChapter DESC");

        while ($reportedData = $reportedReq->fetch())
        {
            $reportedCmt[] = new Comment($reportedData);
        }

        return $reportedCmt;
    }

    public function countComments()
    {   
        $countCmtReq = $this->_db->prepare("SELECT COUNT(*) AS commentNumber FROM comments WHERE postChapter = ? AND reportComment = '0'");
        $countCmtReq->execute([
            $_GET['chapterNb']
        ]);

        return $countCmtReq->fetchColumn();
    }

    public function reportTheComment()
    {
        $reportReq = $this->_db->prepare('UPDATE comments SET reportComment = 1 WHERE id = :commentId');
        $reportReq->execute([
            'commentId' => $_GET['id']
        ]);

    }

    public function unreportTheComment()
    {
        $unreportReq = $this->_db->prepare('UPDATE comments SET reportComment = 0 WHERE id = :commentId');
        $unreportReq->execute([
            'commentId' => $_GET['id']
        ]);

    }

    // public function updateReport()
    // {
    //     $updateReport = new Comment();

    //     $reportReq = $this->_db->prepare('UPDATE comments SET reportComment = :reportCmt WHERE id = :commentId');
    //     $reportReq->execute([
    //     'reportCmt' => $updateReport->reportComment(),
    //     'commentId' => $_GET['id']
    //     ]);
    // }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}