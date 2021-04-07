<?php
class Post
{
    private $_id;
    private $_chapter;
    private $_title;
    private $_postDate;
    private $_content;

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
        if (isset($data['chapter']))
        {
            $this->setChapter($data['chapter']);
        }
        if (isset($data['title']))
        {
            $this->setTitle($data['title']);
        }
        if (isset($data['postDate']))
        {
            $this->setPostDate($data['postDate']);
        }
        if (isset($data['content']))
        {
            $this->setContent($data['content']);
        }
    }

    //Liste of the getters
    public function id() { return $this->_id; }
    public function chapter() { return $this->_chapter; }
    public function title() { return $this->_title; }
    public function postDate() { return $this->_postDate; }
    public function content() { return $this->_content; }

    //Liste of the setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
          $this->_id = $id;
        }
    }

    public function setChapter($chapter)
    {
        $chapter = (int) $chapter;
        if ($chapter > 0) 
        {
            $this->_chapter = $chapter;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title))
        {
            $this->_title = $title;
        }
    }

    public function setPostDate($postDate)
    {
        $this->_postDate = $postDate;
    }
    
    public function setContent($content)
    {
        if (is_string($content))
        {
            $this->_content = $content;
        }
    }
}