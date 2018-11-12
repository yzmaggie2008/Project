<?php
//fix the head() doesn't redirect bug :)
ob_start();
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// get database connection
include_once '../config/database.php';

// instantiate corkboard object
include_once '../objects/Corkboard.php';

$database = new Database();
$db = $database->getConnection();

//get data from database
$corkboard = new Corkboard($db);

// get posted data
$corkboard->title = $_POST['title'];
$corkboard->category = $_POST['category'];
$permission = $_POST['permission'];
$corkboard->password = $_POST['password'];

//get user email
session_start();
$corkboard->email = $_SESSION['email'];

//                exit;
// make sure data is not empty
if(
    !empty($corkboard->title) &&
    !empty($corkboard->category) &&
    !empty($corkboard->email)
) {
    // create the product
    if ($corkboard->addCorkboard()) {

        // set response code - 201 created
//        http_response_code(201);

        // tell the user
        //echo json_encode(array("message" => "corkboard is added."));

        if ($permission == "public") {
            if($corkboard->addPublicCorkboard()){
                header("Location: ../../Front%20End/html/view-corkboard.html?corkboardId=$corkboard->corkboard_id");
            }
        } else {
            if($corkboard->addPrivateCorkboard()){
                header("Location: ../../Front%20End/html/view-corkboard.html?corkboardId=$corkboard->corkboard_id");
            }
        }
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add corkboard."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add corkboard. Data is incomplete."));
}


ob_end_flush();
?>