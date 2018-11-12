<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/25/18
 * Time: 11:38 AM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/Corkboard.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$corkboard = new Corkboard($db);

session_start();
$corkboard->user_email = $_SESSION['email'];
$corkboardId = $_GET['corkboardId'];

// query products
$stmt=$corkboard->watched();
$num = $stmt->rowCount();
$watched = false;

$corkboard_arr=array();
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

        if($corkboard_ID == $corkboardId) {
            $watched = true;
        }
    }
}

$corkboard_arr=array(
    "watched" => $watched
);
echo json_encode($corkboard_arr);