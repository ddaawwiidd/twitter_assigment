<?php
/*
 * CREATE TABLE Tweets(
 * id int AUTO_INCREMENT,
 * id_user int,
 * tweet_body varchar(255),
 * post_date date,
 * PRIMARY KEY(id),
 * FOREIGN KEY(id_user) REFERENCES Users (id) [ON DELETE CASCADE]
 * );
 */
class Tweet
{
    static private $connection;

    static public function SetConnection(mysqli $newConnection)
    {
        Tweet::$connection = $newConnection;
    }

    static public function GetAllTweets()
    {
        $ret = [];
        $sql = "SELECT * FROM Tweets";
        $result = self::$connection->query($sql);

        if($result != false)
        {
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $tweet = new Tweet($row["id"], $row["id_user"], $row["tweet_body"], $row["post_date"]);
                    $ret[] = $tweet;
                }
            }
        }
        return $ret;
    }

    static public function createTweet($newIdUser, $newTweetBody)
    {
        $sql = "INSERT INTO Tweets (id_user, tweet_body, post_date) VALUES ('$newIdUser','$newTweetBody', now())";
        $result = self::$connection->query($sql);
        if($result === true)
        {
            $newTweet = new Tweet(self::$connection->insert_id, $newIdUser, $newTweetBody);
            return $newTweet;
        }
        return false;
    }

    static public function showTweetById($id)
    {
        $sql = "SELECT * FROM Tweets WHERE id = $id";
        $result = self::$connection->query($sql);
        if($result === true)
        {
            if($result->num_row === 1)
            {
                $row = $result->fetch_assoc();
                $tweet = new Tweet($row['id'], $row['id_user'], $row['tweet_body'], $row['post_date']);
                return $tweet;
            }
        }
    }

    private $id;
    private $idUser;
    private $tweetBody;
    private $postDate;

    public function __construct($newId, $newIdUser, $newTweetBody, $newPostDate)
    {
        $this->id = $newId;
        $this->idUser = $newIdUser;
        $this->setTweetBody($newTweetBody);
        $this->postDate = $newPostDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function  getIdUser()
    {
        return $this->idUser;
    }

    public function getTweetBody()
    {
        return $this->tweetBody;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }

    public function setTweetBody($newTweetBody)
    {
        if(is_string($newTweetBody))
        {
            return $this->tweetBody = $newTweetBody;
        }
    }

    public function saveToDB()
    {
        $sql = "UPDATE Tweets SET tweet_body='$this->tweetBody' WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result === true)
        {
            return true;
        }
        return false;
    }

    public function loadAllComments($id)
    {
        $ret = [];
        $sql = "SELECT * FROM Comments WHERE Comments.id_user=Users.id AND id_tweet = $id ORDER BY comment_date DESC";
        $result = self::$connection->query($sql);
        if($result === true)
        {
            if($result->num_rows>0)
            {
                while($row = $result->fetch_assoc())
                {
                    $comment = new Tweet($row['id'], $row['name'], $row['id_tweet'], $row['comment_body'], $row['post_date']);
                    $ret[] = $comment;
                }
            }
        }
        return $ret;
    }
}