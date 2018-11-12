<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/25/18
 * Time: 11:00 AM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/Corkboard.php';

$database = new Database();
$db = $database->getConnection();

$corkboard = new Corkboard($db);

// get posted data
$Email = $_POST['userEmail'];
$corkboardId = $_POST['corkboardId'];

// make sure data is not empty
if(
    !empty($Email) &&
    !empty($corkboardId)
){

    // set product property values
    $corkboard->user_email = $Email;
    $corkboard->corkboard_id = $corkboardId;

    // create the product
    if($corkboard->watch()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Watch is added."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add watch."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add watch. Data is incomplete."));
}
?>
