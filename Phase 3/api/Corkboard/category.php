<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/29/18
 * Time: 10:26 AM
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
$stmt=$corkboard->category();
$num = $stmt->rowCount();
$corkboard_arr = array();

// check if more than 0 record found
if($num>0){
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $category_arr=array(
            "category" => $category
        );
        array_push($corkboard_arr, $category_arr);
    }
}


echo json_encode($corkboard_arr);