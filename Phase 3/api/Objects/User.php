<?php
class User
{
    // database connection and table name
    private $conn;

    // object properties
    public $user_name;
    public $email;
    public $password;
    public $owner_email;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function user_info(){
        //get user input from the login form
        $this->email = isset($_POST['email']) ? $_POST['email'] : die();
        $this->input_password = isset($_POST['password']) ? $_POST['password'] : die();

        // query to fetch data
        $query = "SELECT user_name, pin FROM `User` WHERE email= '$this->email'";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // statistic user's public/private corkboard/pushpin
    function corkboard_statistic(){
        // query to fetch data
        $query = "
SELECT u.user_name AS user_name, u.email AS email, IFNULL(public.pushpin_num, 0) AS public_pushpin_num, IFNULL(public.corkboard_num, 0) AS public_corkboard_num, IFNULL(private.pushpin_num, 0) AS private_pushpin_num, IFNULL(private.corkboard_num, 0) AS private_corkboard_num
FROM User u
      LEFT JOIN (SELECT u.email AS email, COUNT(p.pushpinID) AS pushpin_num, COUNT(DISTINCT pc.corkboardID) AS corkboard_num
                 FROM Corkboard c
                        RIGHT JOIN PublicCorkboard pc ON c.corkboardID = pc.corkboardID
                        LEFT JOIN User u ON u.email = c.email
                        RIGHT JOIN Pushpin p ON p.corkboard_ID = c.corkboardID
                 GROUP BY u.email) public ON public.email = u.email
      LEFT JOIN ( SELECT u.email AS email, COUNT(p.pushpinID) AS pushpin_num, COUNT(DISTINCT pc.corkboardID) AS corkboard_num
                 FROM Corkboard c
                       RIGHT JOIN PrivateCorkboard pc ON c.corkboardID = pc.corkboardID
                       LEFT JOIN User u ON u.email = c.email
                        RIGHT JOIN Pushpin p ON p.corkboard_ID = c.corkboardID
                 GROUP BY u.email) private ON private.email = u.email
ORDER BY public_corkboard_num DESC, private_corkboard_num DESC;

";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //follow button
    function follow() {
        // query to insert record
        $query = "INSERT INTO `Follow`(`user_email`, `follower_email`) VALUES ('$this->owner_email','$this->email');";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}