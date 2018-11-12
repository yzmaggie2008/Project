<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/24/18
 * Time: 11:07 AM
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
$stmt = $pushpin->like_list();
$num = $stmt->rowCount();
$like_arr=array();
// check if more than 0 record found
if($num>0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $like_item=array(
            "like_name" => $user_name,
            "email" => $email,
        );
        array_push($like_arr, $like_item);
    }
    echo json_encode($like_arr);
}
else{
    echo json_encode(
        array("message" => "No pushpin like found.")
    );
}
?>
