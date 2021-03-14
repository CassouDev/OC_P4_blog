<?php
class Comment
{
    private $_id;
    private $_postChapter;
    private $_pseudo;
    private $_comment;
    private $_commentDate;
    private $_reportComment;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }
        if (isset($data['postChapter']))
        {
            $this->setPostChapter($data['postChapter']);
        }
        if (isset($data['pseudo']))
        {
            $this->setPseudo($data['pseudo']);
        }
        if (isset($data['comment']))
        {
            $this->setComment($data['comment']);
        }
        if (isset($data['commentDate']))
        {
            $this->setCommentDate($data['commentDate']);
        }
        if (isset($data['reportComment']))
        {
            $this->setReportComment($data['reportComment']);
        }
    }

    //Liste des getters
    public function id() { return $this->_id; }
    public function postChapter() { return $this->_postChapter; }
    public function pseudo() { return $this->_pseudo; }
    public function comment() { return $this->_comment; }
    public function commentDate() { return $this->_commentDate; }
    public function reportComment() { return $this->_reportComment; }

    //Liste des setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
          $this->_id = $id;
        }
    }

    public function setPostChapter($postChapter)
    {
        $postChapter = (int) $postChapter;
        if ($postChapter > 0) 
        {
            $this->_postChapter = $postChapter;
        }
    }

    public function setPseudo($pseudo)
    {
        if (is_string($pseudo))
        {
            $this->_pseudo = $pseudo;
        }
    }

    public function setComment($comment)
    {
        if(is_string($comment))
        {
        $this->_comment = $comment;
        }
    }

    public function setCommentDate($commentDate)
    {
        $this->_commentDate = $commentDate;
    }

    public function setReportComment($reportComment)
    {
        if ($reportComment == 0 OR $reportComment == 1)
        {
            $this->_reportComment = $reportComment;
        }
    }
}