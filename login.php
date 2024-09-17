<?php

include "dbconnection.php";

// Input sanitization function
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$email = filter_var(sanitize_input($_POST['email']), FILTER_SANITIZE_EMAIL);
$userpassword = sanitize_input($_POST['userpassword']);

$response = [];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["success"] = "invalid email format";
    echo json_encode($response);
    exit();
}

// Check if email exists
$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_user->execute([$email]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if ($select_user->rowCount() > 0) {
    // Verify the password
    if (password_verify($userpassword, $user['userpassword'])) {
        // Login successful
        $response["success"] = "login successful";
        
        // Optional: You can add session handling or JWT here for managing user authentication
    } else {
        // Incorrect password
        $response["success"] = "incorrect username or password!";
    }
} else {
    // Email does not exist
    $response["success"] = "incorrect username or password!";
}

echo json_encode($response);

?>
