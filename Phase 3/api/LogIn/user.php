<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate User object
include_once '../objects/User.php';

$database = new Database();
$db = $database->getConnection();
$password_match = true;

//get data from database
$user = new User($db);
$stmt = $user->user_info();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$user->user_name = $row['user_name'];
$user->password = $row['pin'];
echo "hello";
//echo $row['user_name'];
//echo json_encode(
//    array("user_name" => "hello")
//);
//check if password is right, if right redirect to home page and start the session
//else login page with a parameter (GET response)
if(strcmp($user->password, $user->input_password) == 0) {
    //set session to use username and email across php pages
    session_start();
    $_SESSION['email'] = $user->email;
    $_SESSION['username'] = $user->user_name;

    //redirect to home page
    header("Location: ../../Front%20End/html/home-page.html");
} else {
    //back to login page
    header("Location: ../../Front%20End/html/login.html?wrong-password=1");
    exit();
}
