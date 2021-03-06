<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/9/18
 * Time: 9:07 PM
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/User.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// query products
$stmt = $user->corkboard_statistic();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // user's array
    $users_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $user_item=array(
            "email" => $email,
            "user_name" => $user_name,
            "public_corkboard_num" => $public_corkboard_num,
            "public_pushpin_num" => $public_pushpin_num,
            "private_corkboard_num" => $private_corkboard_num,
            "private_pushpin_num" => $private_pushpin_num
        );
        array_push($users_arr, $user_item);
    }

    echo json_encode($users_arr);
}

else{
    echo json_encode(
        array("message" => "No users' statistic info found.")
    );
}
