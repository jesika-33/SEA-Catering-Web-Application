<?php
// php/submit_testimonial.php
header('Content-Type: application/json');
session_start(); // Start session to check login status

require_once 'db_config.php'; // Include database connection

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response['message'] = 'You must be logged in to submit a testimonial.';
    echo json_encode($response);
    exit;
}

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $data) {
    $authorName = trim($data['authorName'] ?? '');
    $testimonialText = trim($data['testimonialText'] ?? '');
    $satisfactionRating = intval($data['satisfactionRating'] ?? 0);
    $userId = $_SESSION['id'] ?? null; // Get user ID from session

    // Server-side validation
    if (empty($authorName) || empty($testimonialText) || $satisfactionRating < 0 || $satisfactionRating > 100) {
        $response['message'] = 'Invalid input: Name, testimonial, and satisfaction rating are required.';
    } else {
        // Sanitize inputs before inserting (though prepared statements handle injection)
        // For display, you'd escape HTML on the frontend. Here, we ensure data integrity.
        $authorName = htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8');
        $testimonialText = htmlspecialchars($testimonialText, ENT_QUOTES, 'UTF-8');

        $sql = "INSERT INTO testimonials (author_name, testimonial_text, satisfaction_rating, user_id) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssii", $authorName, $testimonialText, $satisfactionRating, $userId);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Testimonial submitted successfully!';
            } else {
                $response['message'] = 'Database error: ' . $mysqli->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Failed to prepare statement: ' . $mysqli->error;
        }
    }
} else {
    $response['message'] = 'Invalid request method or missing data.';
}

$mysqli->close();
echo json_encode($response);
?>
