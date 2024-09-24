<?php

include "dbconnection.php";

// Input sanitization function
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$response = [];

// Decode JSON payload
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['email']) && isset($input['userpassword'])) {
    $email = filter_var(sanitize_input($input['email']), FILTER_SANITIZE_EMAIL);
    $userpassword = sanitize_input($input['userpassword']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["success"] = false;
        $response["message"] = "Invalid email format";
        echo json_encode($response);
        exit();
    }

    try {
        // Check if email exists
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $user = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            // Verify the password
            if (password_verify($userpassword, $user['userpassword'])) {
                // Login successful
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                $response["success"] = true;
                $response["message"] = "Login successful";
                $response["user"] = [
                    "id" => $user['id'],
                    "email" => $user['email'],
                    "username" => $user['username']
                ];
            } else {
                // Incorrect password
                $response["success"] = false;
                $response["message"] = "Incorrect username or password!";
            }
        } else {
            // Email does not exist
            $response["success"] = false;
            $response["message"] = "Incorrect username or password!";
        }
    } catch (PDOException $e) {
        $response["success"] = false;
        $response["message"] = "Database error";
        $response["error"] = $e->getMessage();
    }
} else {
    $response["success"] = false;
    $response["message"] = "Missing email or password";
}

echo json_encode($response);

?>
