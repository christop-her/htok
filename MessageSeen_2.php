<?php

include "dbconnection.php";

$response = [];

$DoctorEmail = $_POST['DoctorEmail'];
$Lmessage = explode(',', $_POST['Lmessage']);
$email = $_POST['email'];
$messageIds = explode(',', $_POST['messageId']);

for ($i = 0; $i < count($messageIds); $i++) {
    $messageId = $messageIds[$i];
    $message = $Lmessage[$i];

    // Check if the messageId and Lmessage pair already exists in the database
    $select_data = $conn->prepare("SELECT * FROM `messageseen` WHERE DoctorEmail = ? AND email = ? AND Lmessage = ? AND messageId = ?");
    $select_data->execute([$email,$DoctorEmail, $message, $messageId]);

    if ($select_data->rowCount() == 0) {
        // Insert the messageId and Lmessage pair into the database
        
        $insert_message = $conn->prepare("INSERT INTO `messageseen`(DoctorEmail, email, Lmessage, messageId) VALUES(?,?,?,?)");
        $insert_message->execute([$email, $DoctorEmail, $message, $messageId]);

        $response[] = [
            "success" => "Message sent successfully",
            "messageId" => $messageId,
            "Lmessage" => $message
        ];
    } else {
        $response[] = [
            "success" => "Message already exists",
            "messageId" => $messageId,
            "Lmessage" => $message
        ];
    }
}

echo json_encode($response);

?>
