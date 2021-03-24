<?php
class User
{
    private $_id;
    private $_pseudo;
    private $_pass;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data)
    {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }
        if (isset($data['pseudo']))
        {
            $this->setPseudo($data['pseudo']);
        }
        if (isset($data['pass']))
        {
            $this->setPass($data['pass']);
        }
    }

    //List of the guetters
    public function id() { return $this->_id; }
    public function pseudo() { return $this->_pseudo; }
    public function pass() { return $this->_pass; }    
    
    //Liste of the setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
          $this->_id = $id;
        }
    }
    public function setPseudo($pseudo)
    {
        if (is_string($pseudo))
        {
          $this->_pseudo = $pseudo;
        }
    }
    public function setPass($pass)
    {
        if (is_string($pass))
        {
          $this->_pass = $pass;
        }
    }
}