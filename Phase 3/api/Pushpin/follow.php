<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/24/18
 * Time: 3:02 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate user object
include_once '../objects/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);


// get posted data
$Email = $_POST['userEmail'];
$OwnerEmail = $_POST['ownerEmail'];


// make sure data is not empty
if(
    !empty($Email) &&
    !empty($OwnerEmail)
){

    // set user property values
    $user->email = $Email;
    $user->owner_email = $OwnerEmail;

    // create the product
    if($user->follow()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Follow is added."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add Follow."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add Follow. Data is incomplete."));
}
?>
