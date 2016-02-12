<?php
/*
 * CREATE TABLE Tweets(
 * id int AUTO_INCREMENT,
 * id_user int,
 * tweet_body varchar(140),
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

    static public function CreateTweet($newIdUser, $newTweetBody)
    {

        $newPostDate = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO Tweets (id_user, tweet_body, post_date) VALUES ('$newIdUser','$newTweetBody','$newPostDate')";
        $result = self::$connection->query($sql);
        if($result == true)
        {
            $newTweet = new Tweet(self::$connection->insert_id, $newIdUser, $newTweetBody, $newPostDate);
            return $newTweet;
        }
        return false;
    }

    static public function GetAllTweets()
    {
        $ret = [];
        $sql = "SELECT * FROM Tweets ORDER BY post_date DESC";
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

    static public function ShowTweetById($id)
    {
        $sql = "SELECT * FROM Tweets WHERE id = $id";
        $result = self::$connection->query($sql);

        if($result != false)
        {
            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                $newTweet = new Tweet($row['id'], $row['id_user'], $row['tweet_body'], $row['post_date']);
                return $newTweet;
            }
        }
        return false;
    }

    private $id;
    private $idUser;
    private $tweetBody;
    private $postDate;

    public function __construct($newId, $newIdUser, $newTweetBody, $newPostDate)
    {
        $this->id = intval($newId);
        $this->idUser = intval($newIdUser);
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



    public function updateTweet($newTweetBody)
    {
        $sql = "UPDATE Tweets SET tweet_body='$newTweetBody' WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result != false)
        {
            return true;
        }
        return false;
    }

    public function getAllComments()
    {
        $ret = [];
        $sql = "SELECT * FROM Comments WHERE id_tweet =$this->id ORDER BY comment_date DESC";
        $result = self::$connection->query($sql);
        if ($result != false)
        {
            if ($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    $comment = new Comment($row['id'], $row['id_user'], $row['id_tweet'], $row['comment_body'], $row['comment_date']);
                    $ret[] = $comment;
                }
            }
        }
        return $ret;
    }

    public function removeTweet()
    {
        $sql = "DELETE FROM Tweets WHERE id =$this->id";
        self::$connection->query($sql);
    }

    }