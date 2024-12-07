<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://stackpath.bootstrapcdn.com https://code.jquery.com https://cdn.jsdelivr.net; style-src 'self' https://stackpath.bootstrapcdn.com; img-src 'self' data:; font-src 'self'; connect-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "harvesthub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$message = $data['message'] ?? '';

$errors = [];

if (empty($name)) {
    $errors[] = "Name is required.";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email is required.";
}

if (empty($message)) {
    $errors[] = "Message is required.";
}
if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit; 
}


$name = htmlspecialchars(trim($name));
$email = htmlspecialchars(trim($email));
$message = htmlspecialchars(trim($message));


$sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    exit;
}

$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
}
$stmt->close();
$conn->close();
?>
