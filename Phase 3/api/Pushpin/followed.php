<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/25/18
 * Time: 1:52 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/pushpin.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$pushpin = new Pushpin($db);

session_start();
$pushpin->user_email = $_SESSION['email'];
$pushpin->corkboardID = $_GET['corkboardId'];

// query products
$stmt=$pushpin->followed();
$num = $stmt->rowCount();
$followed = false;

$pushpin_arr=array();
// check if more than 0 record found
if($num>0){
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
//        echo json_encode($row);
        if($pushpin->user_email == $follower_email) {
            $followed = true;
        }
    }
}

$pushpin_arr=array(
    "followed" => $followed
);
echo json_encode($pushpin_arr);