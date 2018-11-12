<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 9:08 PM
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/Pushpin.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$pushpin = new Pushpin($db);



// query the pushpin
$stmt = $pushpin->view_pushpin();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // user's array
//    $pushpins_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
    //start the session to get user email
    session_start();
    //check if the current pushpin below to current user
    if(strcmp($email, $_SESSION['email']) == 0) {
        $is_current_user = 1;
    } else {
        $is_current_user = 0;
    };
    $pushpin_item=array(
        "user_name" => $user_name,
        "email" => $email,
        "description" => $description,
        "date" => $date,
        "time" => $time,
        "corkboard_ID" => $corkboard_ID,
        "title" => $title,
        "site" => $site,
        "url" => $url,
        "is_current_user" => $is_current_user
);
    echo json_encode($pushpin_item);
}

else{
    echo json_encode(
        array("message" => "No pushpin info found.")
    );
}
?>
