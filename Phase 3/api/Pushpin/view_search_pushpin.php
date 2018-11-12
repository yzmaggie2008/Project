<?php
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

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query pushpin
$stmt = $pushpin->search_pushpin($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $pushpin_arr=array();
    $pushpin_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $pushpin_item=array(
            "description" => $description,
            "title" => $title,
            "user_name" => $user_name,
            "url" => $url
        );
 
        array_push($pushpin_arr["records"], $pushpin_item);
    }

    // set response code - 200 OK
    http_response_code(200);
    
    // show products data
    echo json_encode($pushpin_arr);
    }

    else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No pushpin found.")
    );
}
?>