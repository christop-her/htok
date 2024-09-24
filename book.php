<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];
include "dbconnection.php";

// Input sanitization function
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$response = [];

// Decode JSON payload
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['DoctorEmail']) && isset($input['email']) && isset($input['reason'])) {
    $user_id = $_SESSION['user_id'];
    $DoctorEmail = filter_var(sanitize_input($input['DoctorEmail']), FILTER_SANITIZE_EMAIL);
    $email = filter_var(sanitize_input($input['email']), FILTER_SANITIZE_EMAIL);
    $reason = sanitize_input($input['reason']);

    try {
        // Check if the booking already exists for the specific user
        $select_user = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND DoctorEmail = ? AND reason = ?");
        $select_user->execute([$user_id, $DoctorEmail, $reason]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            http_response_code(409); // Conflict
            $response["success"] = false;
            $response["message"] = "Already booked";
        } else {
            // Insert the new booking
            $insert_user = $conn->prepare("INSERT INTO `bookings` (user_id, DoctorEmail, email, reason, created_at, A_status) VALUES (?, ?, ?, ?, CURRENT_DATE, 'unconfirmed')");
            $insert_user->execute([$user_id, $DoctorEmail, $email, $reason]);

            if ($insert_user) {
                http_response_code(201); // Created
                $response["success"] = true;
                $response["message"] = "Booked successfully";
            } else {
                http_response_code(500); // Internal Server Error
                $response["success"] = false;
                $response["message"] = "Unable to book appointment";
            }
        }
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        $response["success"] = false;
        $response["message"] = "Database error";
        $response["error"] = $e->getMessage();
    }
} else {
    http_response_code(400); // Bad Request
    $response["success"] = false;
    $response["message"] = "Missing required fields";
}

echo json_encode($response);

?>
