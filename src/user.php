<?php

/*
 * CREATE TABLE Users(
 * id int AUTO_INCREMENT,
 * name varchar(255),
 * email varchar(255) UNIQUE,
 * password char(60),
 * description varchar(255),
 * PRIMARY KEY(id)
 * );
 */
class User
{
    static private $connection;

    static public function SetConnection(mysqli $newConnection)
    {
        User::$connection = $newConnection;
    }


    static public function RegisterUser($newName, $newEmail, $password1, $password2, $newDescription)
    {
        if($password1 != $password2)
        {
            return false;
        }
        $options = [
        'cost' => 11,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Users (name, email, password, description)
        VALUES ('$newName', '$newEmail', '$hashedPassword', '$newDescription')";


        $result = self::$connection->query($sql);
        if($result === true)
        {
            $newUser = new User(self::$connection->insert_id, $newName, $newEmail, $newDescription);
            return $newUser;
        }
        return false;
    }

    static public function LogInUser($email, $password)
    {
        $sql = "SELECT * FROM Users WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if($result != false)
        {
            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                $isPasswordOk = password_verify($password, $row["password"]);
                if($isPasswordOk === true)
                {
                    $user = new User($row["id"], $row["name"], $row["email"], $row["description"]);
                    return $user;
                }
            }
        }
        return false;
    }

    static public function GetUserById($idToLoad)
    {
        $sql = "SELECT * FROM Users WHERE id = $idToLoad";
        $result = self::$connection->query($sql);

        if($result != false)
        {
            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                $user = new User($row["id"], $row["name"], $row["email"], $row["description"]);
                return $user;
            }
        }
        return false;
    }

    static public function GetAllUsers()
    {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if($result != false)
        {
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $user = new User($row["id"], $row["name"], $row["email"], $row["description"]);
                    $ret[] = $user;
                }
            }
        }
        return $ret;
    }

    private $id;
    private $name;
    private $email;
    private $description;

    public function __construct($newId, $newName, $newEmail, $newDescription)
    {
        $this->id = intval($newId);
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

    public function changeDescription($newDescription)
    {
        $sql = "UPDATE Users SET description='$newDescription' WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result === true)
        {
            return true;
        }
        return false;
    }

    public function loadAllTweets()
    {
        $ret = [];
        $sql = "SELECT * FROM Tweets WHERE id_user = ($this->id) ORDER BY post_date DESC";
        $result = self::$connection->query($sql);
        if($result != false)
        {
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $tweet = new Tweet($row['id'], $row['id_user'], $row['tweet_body'], $row['post_date']);
                    $ret[] = $tweet;
                }
            }
        }
        return $ret;
    }

    public function loadAllSentMsg()
    {
        $ret = [];
        $sql = "SELECT * FROM Messages WHERE id_sent=$this->id ORDER BY date_msg DESC";
        $result = self::$connection->query($sql);
        if ($result != false)
        {
            if ($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    $message = new Message($row['id'], $row['id_sent'], $row['id_received'], $row['body_msg'], $row['date_msg'], $row['read_msg']);
                    $ret[] = $message;
                }
            }
        }
        return $ret;
    }

    public function loadAllReceivedMsg()
    {
        $ret = [];
        $sql = "SELECT * FROM Messages WHERE id_received=$this->id ORDER BY date_msg DESC";
        $result = self::$connection->query($sql);
        if ($result != false)
        {
            if ($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    $message = new Message($row['id'], $row['id_sent'], $row['id_received'], $row['body_msg'], $row['date_msg'], $row['read_msg']);
                    $ret[] = $message;
                }
            }
        }
        return $ret;
    }

}