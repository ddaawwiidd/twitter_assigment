<?php
/*
  CREATE TABLE Messages(
    id INT AUTO_INCREMENT,
    id_sent INT,
    id_received INT,
    body_msg VARCHAR(255),
    date_msg DATETIME,
    read INT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_sent) REFERENCES Users(id),
    FOREIGN KEY (id_received) REFERENCES Users(id)
    );
 */
class Message
{
    static private $connection;

    static public function SetConnection(mysqli $newConnection)
    {
        Message::$connection = $newConnection;
    }

    static public function CreateMsg($newIdSent, $newIdReceived, $newBodyMsg)
    {
        $newDateMsg = date('Y-m-d H:i:s', time());
        $newReadMsg = 1;
        $sql = "INSERT INTO Messages(id_sent, id_received, body_msg, date_msg, read_msg) VALUES ('$newIdSent', '$newIdReceived', '$newBodyMsg', '$newDateMsg', '$newReadMsg')";
        $result = self::$connection->query($sql);
        if ($result == true)
        {
            $newMsg = new Message(self::$connection->insert_id, $newIdSent, $newIdReceived, $newBodyMsg, $newDateMsg, $newReadMsg);
            return $newMsg;
        }
        return false;
    }

    static public function LoadMsgById($newId)
    {
        $sql = "SELECT * FROM Messages where id = $newId";
        $result = self::$connection->query($sql);
        if ($result != false)
        {
            if ($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                $newMessage = new Message($row['id'], $row['id_sent'], $row['id_received'], $row['body_msg'], $row['date_msg'], $row['read_msg']);
                return $newMessage;
            }
        }
        return false;
    }

    private $id;
    private $idSent;
    private $idReceived;
    private $bodyMsg;
    private $dateMsg;
    private $readMsg;

    public function __construct($newId, $newIdSent, $newIdReceived, $newBodyMsg, $newDateMsg, $newReadMsg)
    {
        $this->id = intval($newId);
        $this->setIdSent($newIdSent);
        $this->setIdReceived($newIdReceived);
        $this->setBodyMsg($newBodyMsg);
        $this->setDateMsg($newDateMsg);
        $this->setReadMsg($newReadMsg);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdSent()
    {
        return $this->idSent;
    }

    public function setIdSent($newIdSent)
    {
        return $this->idSent = $newIdSent;
    }

    public function getIdReceived()
    {
        return $this->idReceived;
    }

    public function setIdReceived($newIdReceived)
    {
        return $this->idReceived = $newIdReceived;
    }

    public function getBodyMsg()
    {
        return $this->bodyMsg;
    }

    public function setBodyMsg($newBodyMsg)
    {
        if(strlen($newBodyMsg) > 0)
        {
            return($this->bodyMsg = $newBodyMsg);
        }
        return false;
    }

    public function getDateMsg()
    {
        return $this->dateMsg;
    }

    public function setDateMsg($newDateMsg)
    {
        return $this->dateMsg = $newDateMsg;
    }

    public function getReadMsg()
    {
        return $this->readMsg;
    }

    public function setReadMsg($newRead)
    {
        if($newRead == 1 || $newRead == 0) {
            $this->readMsg = $newRead;
        }
    }

    public function updateRead()
    {
        $sql = "UPDATE Messages SET opened = 0 WHERE id=$this->id";
        $result = self::$connection->query($sql);
        if ($result == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}