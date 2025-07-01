<?php
// php/session_check.php
header('Content-Type: application/json');
session_start();

$response = ['loggedIn' => false, 'user' => null];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $response['loggedIn'] = true;
    $response['user'] = [
        'id' => $_SESSION['id'],
        'full_name' => $_SESSION['full_name'],
        'email' => $_SESSION['email'],
        'role' => $_SESSION['role'] // Include role
    ];
}

echo json_encode($response);
exit;
?>