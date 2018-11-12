<?php
/**
 * Created by PhpStorm.
 * User: guangting
 * Date: 10/18/18
 * Time: 3:59 PM
 */
session_start();
$user_name = $_SESSION['username'];
echo json_encode(
    array("user_name" => $user_name)
);