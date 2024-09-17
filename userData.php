<?php

include "dbconnection.php";


if(isset($_POST['email'])){
    
$email = $_POST['email'];

$response = [];

$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_user->execute([$email]);

if($select_user->rowCount() > 0){
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $response["data"][] = $fetch_user;
    $response["success"] = "login successful";
}
}
echo json_encode($response);