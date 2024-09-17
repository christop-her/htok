<?php

include "dbconnection.php";

// Input sanitization and validation
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$username = sanitize_input($_POST['username']);
$email = filter_var(sanitize_input($_POST['email']), FILTER_SANITIZE_EMAIL);
$userpassword = sanitize_input($_POST['userpassword']);
$cpassword = sanitize_input($_POST['cpassword']);
$userrole = sanitize_input($_POST['userrole']);
$department = sanitize_input($_POST['department']);
$gender = sanitize_input($_POST['gender']);
$dateOfBirth = sanitize_input($_POST['dateOfBirth']);

$response = [];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["success"] = "invalid email format";
    echo json_encode($response);
    exit();
}

// Validate password length (at least 8 characters)
if (strlen($userpassword) < 8) {
    $response["success"] = "password must be at least 8 characters";
    echo json_encode($response);
    exit();
}

// Check if passwords match
if ($userpassword != $cpassword) {
    $response["success"] = "confirm password incorrect";
    echo json_encode($response);
    exit();
}

// Check if the email already exists
$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_user->execute([$email]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if ($select_user->rowCount() > 0) {
    $response["success"] = "email already exists";
} else {
    // Hash the password securely
    $hashed_password = password_hash($userpassword, PASSWORD_BCRYPT);

    // Insert the new user
    $insert_user = $conn->prepare("INSERT INTO `users` (username, email, userpassword, userrole, department, gender, dateOfBirth) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_user->execute([$username, $email, $hashed_password, $userrole, $department, $gender, $dateOfBirth]);

    if ($insert_user) {
        $response["success"] = "successful";
    } else {
        $response["success"] = "failed to register";
    }
}

echo json_encode($response);

?>
