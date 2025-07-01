<?php
// php/register.php
header('Content-Type: application/json');
session_start(); // Start session for potential future use (e.g., auto-login after register)

require_once 'db_config.php'; // Include database connection

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $data) {
    $fullName = trim($data['fullName'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    // Server-side validation
    if (empty($fullName) || empty($email) || empty($password)) {
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
    } elseif (strlen($password) < 8 ||
              !preg_match('/[A-Z]/', $password) ||
              !preg_match('/[a-z]/', $password) ||
              !preg_match('/[0-9]/', $password) ||
              !preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~` ]/', $password)) {
        $response['message'] = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
    } else {
        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $response['message'] = 'This email is already registered.';
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user into database
                    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'user')"; // Default role 'user'
                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->bind_param("sss", $param_fullName, $param_email, $param_password);
                        $param_fullName = $fullName;
                        $param_email = $email;
                        $param_password = $hashed_password;

                        if ($stmt->execute()) {
                            $response['success'] = true;
                            $response['message'] = 'Registration successful!';
                            // Optionally, log the user in automatically after registration
                            // $_SESSION['loggedin'] = true;
                            // $_SESSION['id'] = $mysqli->insert_id;
                            // $_SESSION['email'] = $email;
                            // $_SESSION['role'] = 'user';
                        } else {
                            $response['message'] = 'Error: Could not register user. ' . $mysqli->error;
                        }
                    } else {
                        $response['message'] = 'Error: Could not prepare insert statement.';
                    }
                }
            } else {
                $response['message'] = 'Error checking email existence.';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Error preparing email check statement.';
        }
    }
} else {
    $response['message'] = 'Invalid request.';
}

$mysqli->close();
echo json_encode($response);
?>