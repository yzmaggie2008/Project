<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/18/18
 * Time: 10:08 PM
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

// query the corkboard
$stmt = $corkboard->readCorkboardImg();
$num = $stmt->rowCount();
$corkboards_arr=array();
// check if more than 0 record found
if($num>0){

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

    $corkboard_item=array(
        "url" => $url,
        "pushpinID" => $pushpinID
    );
    array_push($corkboards_arr, $corkboard_item);
    }
    echo json_encode($corkboards_arr);
}

else{
    echo json_encode(
        array("message" => "No corkboard info found.")
    );
}
?>
