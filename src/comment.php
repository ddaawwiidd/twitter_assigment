<?php
/*
 * CREATE TABLE Comments(
 * id int AUTO_INCREMENT,
 * id_user int NOT NULL,
 * id_tweet int NOT_NULL,
 * comment_date DATETIME,
 * comment_body varchar(60),
 * FOREIGN KEY(id_user) REFERENCES Users(id),
 * FOREIGN KEY(id_tweet) REFERENCES Tweets(id),
 * PRIMARY KEY(id)
 * );
 */
class Comment
{
    static private $connection;

    static public function SetConnection(mysqli $newConnection)
    {
        Comment::$connection = $newConnection;
    }

    static public function CreateComment($newIdUser, $newIdTweet, $newCommentBody)
    {
        $newCommentDate = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO Comments (id_user, id_tweet, comment_body, comment_date) VALUES ('$newIdUser','$newIdTweet','$newCommentBody','$newCommentDate')";
        $result = self::$connection->query($sql);
        if($result == true)
        {
            $newComment = new Comment(self::$connection->insert_id, $newIdUser, $newIdTweet, $newCommentBody, $newCommentDate);
            return $newComment;
        }
        return false;
    }

    static public function showCommentById($id)
    {
        $sql = "SELECT * FROM Comments WHERE id = $id";
        $result = self::$connection->query($sql);
        if($result != false)
        {
            if($result->num_row == 1)
            {
                $row = $result->fetch_assoc();
                $comment = new Comment($row['id'], $row['id_user'],$row['id_tweet'], $row['comment_body'], $row['comment_date']);
                return $comment;
            }
        }
    }

    private $id;
    private $idUser;
    private $idTweet;
    private $commentDate;
    private $commentBody;

    public function __construct($newId, $newIdUser, $newIdTweet, $newCommentBody, $newCommentDate)
    {
        $this->id = intval($newId);
        $this->setIdUser($newIdUser);
        $this->setIdTweet($newIdTweet);
        $this->setCommentBody($newCommentBody);
        $this->setCommentDate($newCommentDate);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getIdTweet()
    {
        return $this->idTweet;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function getCommentBody()
    {
        return $this->commentBody;
    }

    public function setIdUser($newIdUser)
    {
        return $this->idUser = $newIdUser;
    }

    public function setIdTweet($newIdTweet)
    {
        return $this->idTweet = $newIdTweet;
    }

    public function setCommentDate($newCommentDate)
    {
        return $this->commentDate = $newCommentDate;
    }

    public function setCommentBody($newCommentBody)
    {
        if(is_string($newCommentBody))
        {
            return $this->commentBody = $newCommentBody;
        }
    }


}