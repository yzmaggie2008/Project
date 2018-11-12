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
include_once '../objects/Corkboard.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$corkboard = new Corkboard($db);

// query products
$stmt = $corkboard->myCorkboard();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // user's array
    $corkboards_arr=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $corkboard_item=array(
            "corkboardID" => $corkboardID,
            "title" => $title,
            "num" => $num,
            "privateID" => $privateID);
        array_push($corkboards_arr, $corkboard_item);
    }

    echo json_encode($corkboards_arr);
}

else{
    echo json_encode(
        array("message" => "No users' corkboard info found.")
    );
}

?>