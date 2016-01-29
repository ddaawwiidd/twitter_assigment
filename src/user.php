<?php
class User
{
    private $id;
    private $name;
    private $email;
    private $description;

    public function __construct($newId, $newName, $newEmail, $newDescription)
    {
        $this->id = $newId;
        $this->name = $newName;
        $this->email = $newEmail;
        $this->setDescription($newDescription);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription ($newDescription)
    {
        if(is_string($newDescription))
        {
            $this->description = $newDescription;
        }

    }
}