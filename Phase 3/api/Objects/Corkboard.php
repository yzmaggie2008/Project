<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 8:59 PM
 */

class Corkboard
{
    // database connection and table name
    private $conn;

    // object properties
    public $title;
    public $email;
    public $user_email;
    public $corkboard_id;
    public $category;
    public $permission;
    public $password;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //get recent corkboard data
    function myCorkboard(){
        //start the session to get user email
        session_start();
        $this->email = $_SESSION['email'];
        // query current user's corkboard info
        $query = "SELECT c.corkboardID, c.title, COUNT(pushpinID) AS num, pc.corkboardID AS privateID
FROM Corkboard c
       LEFT JOIN Pushpin p ON c.corkboardID = p.corkboard_ID
       LEFT JOIN PrivateCorkboard pc ON pc.corkboardID = c.corkboardID
WHERE c.email = '$this->email'
GROUP BY c.corkboardID;";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //Query is not correct, To be updated by pushpin date and time
    function recentCorkboard(){
        //start the session to get user email
        session_start();
        // query current user's corkboard info
        $query = "SELECT c.corkboardID, c.title, u.user_name, c.date, c.time, IFNULL(pc.corkboardID, 0) AS privateID
FROM Corkboard c
       LEFT JOIN PrivateCorkboard pc ON pc.corkboardID = c.corkboardID
       LEFT JOIN User u ON u.email = c.email
ORDER BY c.date DESC, c.time DESC LIMIT 4;";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //Query is not correct, To be updated by pushpin date and time
    function allCorkboard(){
        //start the session to get user email
        session_start();
        // query current user's corkboard info
        $query = "SELECT c.corkboardID, c.title, u.user_name, c.date, c.time, IFNULL(pc.corkboardID, 0) AS privateID
FROM Corkboard c
       LEFT JOIN PrivateCorkboard pc ON pc.corkboardID = c.corkboardID
       LEFT JOIN User u ON u.email = c.email
ORDER BY c.date DESC, c.time DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


//Query is not correct, To be updated by pushpin date and time
function readOneCorkboard()
{
    //get the corkboard id from url parameter(GET method)
    $this->corkboard_id = $_GET['corkboardId'];
//    echo $corkboard_id;

    // query current user's corkboard info
    $query = "
SELECT * FROM
(SELECT c.corkboardID, u.email, c.date, c.time, c.title, c.category, u.user_name, IFNULL(pc.corkboardID, 0) AS privateID, COUNT(w.user_email) AS num
FROM Corkboard c
     LEFT JOIN User u ON c.email= u.email
     LEFT JOIN PrivateCorkboard pc ON c.corkboardID = pc.corkboardID
     LEFT JOIN Watch w ON w.corkboard_ID = c.corkboardID
GROUP BY c.corkboardID) view
WHERE view.corkboardID='$this->corkboard_id';
";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

    function readCorkboardImg()
    {
        //get the corkboard id from url parameter(GET method)
        $this->corkboard_id = $_GET['corkboardId'];

        // query current user's corkboard info
        $query = "
SELECT url, pushpinID
FROM Pushpin
WHERE corkboard_ID='$this->corkboard_id';
";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    //watch button
    function watch() {
        // query to insert record
        $query = "INSERT INTO `Watch`(`user_email`, `corkboard_ID`) VALUES ('$this->user_email', $this->corkboard_id);";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }



function watched()
{
    // query to insert record
    $query = "SELECT * FROM Watch w
              WHERE w.user_email = '$this->user_email'
";


// prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

function isPrivate()
    {
        // query to insert record
        $query = "SELECT corkboardID FROM PrivateCorkboard";


// prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

function category()
{
    // query to insert record
    $query = "SELECT category FROM Category";


// prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}


function addCorkboard() {
    $query = "INSERT INTO  `Corkboard` (`email`, `date`, `time`, `category`, `title`) 
    VALUES('$this->email', NOW(), NOW(), '$this->category', '$this->title');";


    // prepare query
    $stmt = $this->conn->prepare($query);

    // execute query
    if($stmt->execute()){
        $this->corkboard_id = $this->conn->lastInsertId();
        return true;
    }
    return false;
}


function addPublicCorkboard()
{
    // query to insert record
    $query = "INSERT INTO  `PublicCorkboard` (`corkboardID`) 
    VALUES(LAST_INSERT_ID());";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // execute query
    if ($stmt->execute()) {
        return true;
    }

    return false;
}

function addPrivateCorkboard()
{
    // query to insert record
    $query = "INSERT INTO  `PrivateCorkboard` (`corkboardID`,`password`) 
    VALUES(LAST_INSERT_ID(),'$this->password');
";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // execute query
    if ($stmt->execute()) {
        return true;
    }

    return false;
}

};