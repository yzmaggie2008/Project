<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 9:07 PM
 */

// get database connection
include_once '../config/database.php';

// instantiate pushpin object
include_once '../objects/Pushpin.php';

//fix the head() doesn't redirect bug :)
//header("Location: ../../Front%20End/html/home-page.html");
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$database = new Database();
$db = $database->getConnection();

//get data from database
$pushpin = new pushpin($db);
//$pushpin->url = 'testphp';
//$pushpin->description ="haha";
//$pushpin->corkboardID = 5;
//$tags="";
// get posted data
$pushpin->url = $_POST['url'];
$pushpin->description = $_POST['description'];
$pushpin->corkboardID = $_GET['corkboardId'];
//echo $pushpin->corkboardID;
$tags = $_POST['tags'];

//echo $pushpin;

//parse the tag string into an array
$tagsArray = explode(", ", $tags);

// make sure data is not empty
if (!empty($pushpin->url) && !empty($pushpin->description)) {
    // create the product
    if ($pushpin->addPushpin()) {
        // set response code - 201 created
//        http_response_code(201);
            foreach ($tagsArray as $pushpin->tag) {
                if ($pushpin->tag != "" && $pushpin->addATag()) {
                    //echo json_encode(array("message" => "tag is added."));

                } else {
                    //echo json_encode(array("message" => "tag unable to added."));
                }
            }
            //redirect to view corkboard page
        redirect("../../Front%20End/html/view-corkboard.html?corkboardId=$pushpin->corkboardID");

    }
    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add pushpin."));
    }
} else{
    // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add pushpin. Data is incomplete."));
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}