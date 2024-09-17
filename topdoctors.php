<?php

include "dbconnection.php";
   
$userrole = 'practitioner';

$response = [];

$select_user = $conn->prepare("SELECT * FROM `users` WHERE userrole = ?");
$select_user->execute([$userrole]);

if($select_user->rowCount() > 0){
    while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_user;
    $response["success"] = "login successful";
    }
}

echo json_encode($response);