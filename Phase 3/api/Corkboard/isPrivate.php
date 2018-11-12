<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/25/18
 * Time: 2:47 PM
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

$corkboardId = $_GET['corkboardId'];

// query products
$stmt=$corkboard->isPrivate();
$num = $stmt->rowCount();
$isPrivate = false;

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

        if($corkboardID == $corkboardId) {
            $isPrivate = true;
        }
    }
}

$corkboard_arr=array(
    "isPrivate" => $isPrivate
);
echo json_encode($corkboard_arr);