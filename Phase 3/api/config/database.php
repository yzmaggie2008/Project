<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 8:54 PM
 * Source: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */

class database
{
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "team057_p2_schema";
    private $username = "root";
    private $password = "password";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
