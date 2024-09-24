<?php

include "dbconnection.php";

// Input sanitization and validation
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$response = [];

// Decode JSON payload
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['username']) && isset($input['email']) && isset($input['userpassword']) && isset($input['cpassword']) && isset($input['userrole']) && isset($input['department']) && isset($input['gender']) && isset($input['dateOfBirth'])) {
    $username = sanitize_input($input['username']);
    $email = filter_var(sanitize_input($input['email']), FILTER_SANITIZE_EMAIL);
    $userpassword = sanitize_input($input['userpassword']);
    $cpassword = sanitize_input($input['cpassword']);
    $userrole = sanitize_input($input['userrole']);
    $department = sanitize_input($input['department']);
    $gender = sanitize_input($input['gender']);
    $dateOfBirth = sanitize_input($input['dateOfBirth']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        $response["message"] = "invalid email format";
        echo json_encode($response);
        exit();
    }

    // Validate password length (at least 8 characters)
    if (strlen($userpassword) < 8) {
        http_response_code(400); // Bad Request
        $response["message"] = "password must be at least 8 characters";
        echo json_encode($response);
        exit();
    }

    // Check if passwords match
    if ($userpassword != $cpassword) {
        http_response_code(400); // Bad Request
        $response["message"] = "confirm password incorrect";
        echo json_encode($response);
        exit();
    }

    try {
        // Check if the email already exists
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            http_response_code(409); // Conflict
            $response["message"] = "email already exists";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($userpassword, PASSWORD_BCRYPT);

            // Insert the new user
            $insert_user = $conn->prepare("INSERT INTO `users` (username, email, userpassword, userrole, department, gender, dateOfBirth) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_user->execute([$username, $email, $hashed_password, $userrole, $department, $gender, $dateOfBirth]);

            if ($insert_user) {
                // Get the last inserted user ID
                $user_id = $conn->lastInsertId();

                // Prepare the success response
                http_response_code(201); // Created
                $response["message"] = "User successfully registered";
                $response["user"] = [
                    "id" => $user_id,
                    "username" => $username,
                    "email" => $email
                ];
            } else {
                http_response_code(500); // Internal Server Error
                $response["message"] = "failed to register";
            }
        }
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        $response["message"] = "database error";
        $response["error"] = $e->getMessage();
    }
} else {
    http_response_code(400); // Bad Request
    $response["message"] = "missing required fields";
}

echo json_encode($response);

?>
