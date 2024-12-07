<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harvesthub"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}


$crop = $_GET['crop'] ?? null;
$location = $_GET['location'] ?? null;

if (!$crop || !$location) {
    echo json_encode(['error' => 'Missing crop or location parameter.']);
    exit;
}

$apiUrl = "https://api.example.com/prices?crop=" . urlencode($crop) . "&location=" . urlencode($location);

try {
    
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        throw new Exception('Failed to connect to the API.');
    }

    $data = json_decode($response, true);

    if (isset($data['price'])) {
        echo json_encode(['price' => $data['price']]);
    } else {
        echo json_encode(['error' => 'Price information not available for the given crop and location.']);
    }
} catch (Exception $e) {
    
    echo json_encode(['error' => $e->getMessage()]);
}
?>
