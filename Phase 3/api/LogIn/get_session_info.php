<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/18/18
 * Time: 4:12 PM
 */
session_start();
$user_name = $_SESSION['username'];
$email = $_SESSION['email'];

echo json_encode(
    array("user_name" => $user_name,
    "email" => $email)
);