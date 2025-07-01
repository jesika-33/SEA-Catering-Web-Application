<?php
// php/login.php
header('Content-Type: application/json');
session_start(); // Start session

require_once 'db_config.php'; // Include database connection

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $data) {
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    // Server-side validation
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required.';
    } else {
        $sql = "SELECT id, full_name, email, password, role FROM users WHERE email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $fullName, $email, $hashed_password, $role);
                    $stmt->fetch();

                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start a new session
                        session_regenerate_id(true); // Regenerate session ID for security
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $id;
                        $_SESSION['full_name'] = $fullName;
                        $_SESSION['email'] = $email;
                        $_SESSION['role'] = $role; // Store user role in session

                        $response['success'] = true;
                        $response['message'] = 'Login successful!';
                        $response['user'] = [
                            'id' => $id,
                            'full_name' => $fullName,
                            'email' => $email,
                            'role' => $role
                        ];
                    } else {
                        $response['message'] = 'Invalid email or password.';
                    }
                } else {
                    $response['message'] = 'Invalid email or password.';
                }
            } else {
                $response['message'] = 'Error executing login query.';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Error preparing login statement.';
        }
    }
} else {
    $response['message'] = 'Invalid request.';
}

$mysqli->close();
echo json_encode($response);
?>