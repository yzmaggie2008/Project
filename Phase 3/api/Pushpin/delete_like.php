<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/24/18
 * Time: 1:34 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/Pushpin.php';

$database = new Database();
$db = $database->getConnection();

$pushpin = new Pushpin($db);

// get posted data
$Email = $_POST['userEmail'];
$PushpinID = $_POST['pushpinId'];
echo $Email;
echo $PushpinID;

// make sure data is not empty
if(
    !empty($Email) &&
    !empty($PushpinID)
){

    // set product property values
    $pushpin->email = $Email;
    $pushpin->pushpin_id = $PushpinID;

    // create the product
    if($pushpin->deleteLike()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Like is deleted."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete Like."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add Like. Data is incomplete."));
}
?>
