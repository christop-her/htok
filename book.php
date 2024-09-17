<?php

include "dbconnection.php";

   $DoctorEmail = $_POST['DoctorEmail'];
   $email = $_POST['email'];
   $reason = $_POST['reason'];
   

   $response = [];
    
   $select_user = $conn->prepare("SELECT * FROM `bookings` WHERE email = ? AND DoctorEmail = ? AND reason = ?");
   $select_user->execute([$email, $DoctorEmail, $reason,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
       $response["success"] = "booked already";
       
    }else{
   $insert_user = $conn->prepare("INSERT INTO `bookings`(DoctorEmail, email, reason, created_at) VALUES(?,?,?,CURRENT_DATE)");
   $insert_user->execute([$DoctorEmail, $email, $reason]);
   
   $response["success"] = "booked successfully";
    }
    
    echo json_encode($response);

