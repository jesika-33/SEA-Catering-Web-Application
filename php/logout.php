<?php
// php/logout.php
header('Content-Type: application/json');
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

$response = ['success' => true, 'message' => 'Logged out successfully.'];
echo json_encode($response);
exit;
?>
