<?php
require('Comment.php');
require_once('Database.php');

class CommentManager extends Database
{
    public function __construct()
    {
        $this->_db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
        // $this->_db = new PDO('mysql:host=db5001825346.hosting-data.io;dbname=dbs1502331;charset=utf8', 'dbu969252', 'Anima-2012');
        
    }

    public function addComments(Comment $newComment)
    {        
        $insertReq = $this->_db->prepare("INSERT INTO comments(post_id, pseudo, comment, commentDate) VALUES(:post_id, :pseudo, :comment, NOW())");
        $insertReq->execute(array(
            'post_id' => $newComment->post_id(),
            'pseudo' => $newComment->pseudo(),
            'comment' => $newComment->comment()
        ));
    }

    public function deleteCommentFromPost()
    {
        $deleteFromPostReq = $this->_db->prepare('DELETE FROM comments WHERE post_id = :post_id');
        $deleteFromPostReq->execute([
            'post_id' => $_GET['chapterId']
        ]);
    }

    public function deleteComment()
    {
        $deleteComment = $this->_db->prepare('DELETE FROM comments WHERE id = :id');
        $deleteComment->execute([
            'id' => $_GET['id']
        ]);
    }

    public function getOnePostComments()
    {
        $OnePostComments = [];
        
        $postCmtReq = $this->_db->prepare("SELECT id, post_id, pseudo, comment, DATE_FORMAT(commentDate, '%d/%m/%Y') AS commentDate, reportComment FROM comments WHERE post_id = ? AND reportComment = '0' ORDER BY id DESC");
        $postCmtReq->execute([
            $_GET['chapterId']
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

        $unreportedReq = $this->_db->prepare("SELECT id, post_id, pseudo, comment, DATE_FORMAT(commentDate, '%d/%m/%Y') AS commentDate, reportComment FROM comments WHERE reportComment = '0' ORDER BY post_id DESC");
        $unreportedReq->execute();

        while ($unreportedData = $unreportedReq->fetch())
        {
            $unreportedCmt[] = new Comment($unreportedData);
        }

        return $unreportedCmt;
    }

    public function getReportedComments()
    {
        $reportedCmt = [];

        $reportedReq = $this->_db->prepare("SELECT * FROM comments WHERE reportComment = '1' ORDER BY post_id DESC");
        $reportedReq->execute();

        while ($reportedData = $reportedReq->fetch())
        {
            $reportedCmt[] = new Comment($reportedData);
        }

        return $reportedCmt;
    }

    public function countComments()
    {   
        $countCmtReq = $this->_db->prepare("SELECT COUNT(*) AS commentNumber FROM comments WHERE post_id = ? AND reportComment = '0'");
        $countCmtReq->execute([
            $_GET['chapterId']
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
}