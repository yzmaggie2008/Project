<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/18/18
 * Time: 8:58 PM
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
$stmt = $corkboard->readOneCorkboard();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // user's array
//    $corkboards_arr=array();

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
    //check if the current corkboard below to current user
    if(strcmp($email, $_SESSION['email']) == 0) {
        $is_current_user = 1;
    } else {
        $is_current_user = 0;
    };
    $corkboard->email = $email;
    $corkboard->user_email = $_SESSION['email'];
    $corkboard_item=array(
        "ownerEmail" => $email,
        "currentEmail" => $_SESSION['email'],
        "user_name" => $user_name,
        "title" => $title,
        "category" => $category,
        "date" => $date,
        "time" => $time,
        "category" => $category,
        "privateID" => $privateID,
        "num" => $num,

        "is_current_user" => $is_current_user
);
    echo json_encode($corkboard_item);
}

else{
    echo json_encode(
        array("message" => "No corkboard info found.")
    );
}
