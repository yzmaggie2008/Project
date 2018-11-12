<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 8:58 PM
 */

class Pushpin
{
    // database connection and table name
    private $conn;

    // object properties
    public $email;
    public $description;
    public $url;
    public $corkboardID;
    public $pushpin_id;
    public $pushpin_owner_email;
    public $tag;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function popular_site()
    {
        $query = "
SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1) AS site, COUNT(*) AS pushpins
FROM Pushpin
GROUP BY site
ORDER BY pushpins DESC;";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function popular_tags()
    {
        $query = "SELECT t.tags, COUNT(p.pushpinID) AS pushpins,  
COUNT(DISTINCT corkboard_ID) AS unique_corkboards
FROM Pushpin p RIGHT JOIN PushpinTags t ON t.pushpin_ID = p.pushpinID
GROUP BY tags ORDER BY pushpins DESC 
LIMIT 5";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function view_pushpin()
    {
        //get the pushpin id from url parameter(GET method)
        $this->pushpin_id = $_GET['pushpinId'];

        $query = "SELECT c.email, url, p.date, p.time, description, title, user_name, corkboard_ID, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1) AS site
FROM Pushpin p
LEFT JOIN Corkboard c ON c.corkboardID = p.corkboard_ID
LEFT JOIN User u ON c.email = u.email
WHERE p.pushpinID= '$this->pushpin_id'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function search_pushpin($keywords) 
    {
        //select all query
        $query = "SELECT DISTINCT p.description AS description, c.title AS title, u.user_name AS user_name, p.url AS url 
        FROM pushpin p 
        LEFT JOIN pushpintags t ON t.pushpin_ID = p.pushpinID 
        LEFT JOIN corkboard c ON c.corkboardID = p.corkboard_ID 
        RIGHT JOIN publiccorkboard pc ON c.corkboardID = pc.corkboardID 
        LEFT JOIN USER u ON u.email = c.email 
        WHERE p.description LIKE ? OR t.tags LIKE ? OR c.category LIKE ? 
        ORDER BY description ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        

        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function tag_list()
    {
        //get the pushpin id from url parameter(GET method)
        $this->pushpin_id = $_GET['pushpinId'];

        $query = "SELECT tags
FROM PushpinTags
WHERE pushpin_ID= '$this->pushpin_id'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function like_list()
    {
        //get the pushpin id from url parameter(GET method)
        $this->pushpin_id = $_GET['pushpinId'];

        $query = "SELECT u.user_name, u.email
FROM LikeList l
LEFT JOIN User u ON u.email = l.user_email
WHERE pushpin_ID= '$this->pushpin_id'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //add like to likelist
    function addLike()
    {
        // query to insert record
        $query = "INSERT INTO `LikeList`(`user_email`, `pushpin_ID`) VALUES ('$this->email','$this->pushpin_id');";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //add like to likelist
    function deleteLike()
    {
        // query to insert record
        $query = "DELETE FROM `LikeList` WHERE user_email='$this->email' AND pushpin_ID=$this->pushpin_id;";

        $stmt = $this->conn->prepare($query);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function followed()
    {
        // query to insert record
        $query = "SELECT follower_email, corkboardID
FROM Follow f
LEFT JOIN Corkboard c ON c.email = user_email
              WHERE corkboardID = '$this->corkboardID'
";


// prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function addPushpin() {
        //get the corkboard id from url parameter(GET method)
//        $this->corkboardID = $_GET['corkboardId'];
        $query = "INSERT INTO  `Pushpin` (`date`, `time`, `url`, `description`, corkboard_ID) VALUES (NOW(), NOW(), '$this->url', '$this->description', $this->corkboardID);";


        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function addATag() {
        //get the corkboard id from url parameter(GET method)
        $query = "INSERT INTO PushpinTags SET tags = '$this->tag', pushpin_ID = LAST_INSERT_ID();";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    

};

