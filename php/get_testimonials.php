<?php
// php/get_testimonials.php
header('Content-Type: application/json');
session_start(); // Start session (though not strictly needed for fetching public data, good practice)

require_once 'db_config.php'; // Include database connection

$testimonials = [];

$sql = "SELECT author_name, testimonial_text, satisfaction_rating, created_at FROM testimonials ORDER BY created_at DESC";

if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        // No need to htmlspecialchars here, as frontend JS will escape for display
        $testimonials[] = $row;
    }
    $result->free();
} else {
    // Log error but don't expose sensitive info to client
    error_log("Error fetching testimonials: " . $mysqli->error);
    // Optionally send an empty array or an error message to the client
    // For this case, returning an empty array is fine if no testimonials or error
}

$mysqli->close();
echo json_encode($testimonials);
?>
