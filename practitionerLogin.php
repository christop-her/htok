<?php

include "dbconnection.php";

// Input sanitization function
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$email = filter_var(sanitize_input($_POST['email']), FILTER_SANITIZE_EMAIL);
$userpassword = sanitize_input($_POST['userpassword']);
$userrole = sanitize_input($_POST['userrole']);

$response = [];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["success"] = "invalid email format";
    echo json_encode($response);
    exit();
}

// Check if email and user role exist
$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND userrole = ?");
$select_user->execute([$email, $userrole]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if ($select_user->rowCount() > 0) {
    // Verify the password
    if (password_verify($userpassword, $user['userpassword'])) {
        // Login successful
        $response["success"] = "login successful";

    } else {
        // Incorrect password
        $response["success"] = "incorrect username or password!";
    }
} else {
    // Email or role does not exist
    $response["success"] = "incorrect username or password!";
}

echo json_encode($response);


// include "dbconnection.php";


// if(isset($_POST['email']) && isset($_POST['userpassword']) && isset($_POST['userrole']) ){
    
// $email = $_POST['email'];
// $userpassword = $_POST['userpassword'];
// $userrole = $_POST['userrole'];

// $response = [];

// $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND userpassword = ? AND userrole = ?");
// $select_user->execute([$email, $userpassword, $userrole]);

// if($select_user->rowCount() > 0){
//    $response["success"] = "login successful";
// }else{
//     $response["success"] = 'incorrect username or password!';
// }
// }
// echo json_encode($response);


?>
