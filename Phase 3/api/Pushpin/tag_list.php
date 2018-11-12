<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/24/18
 * Time: 10:40 AM
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
$stmt = $pushpin->tag_list();
$num = $stmt->rowCount();
$tags_arr=array();
// check if more than 0 record found
if($num>0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $tags_item=array(
            "tags" => $tags,
        );
        array_push($tags_arr, $tags_item);
    }
    echo json_encode($tags_arr);
}
else{
    echo json_encode(
        array("message" => "No pushpin tag found.")
    );
}
?>
