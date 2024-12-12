<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

$crop = isset($_GET['crop']) ? $_GET['crop'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

if (empty($crop) || empty($location)) {
    echo json_encode(["error" => "Crop and location must be provided."]);
    exit;
}

$api_url = "http://localhost:8000/api/crop-price/?crop=" . urlencode($crop) . "&location=" . urlencode($location);


$response = file_get_contents($api_url);

if ($response === FALSE) {
    echo json_encode(["error" => "Unable to fetch price from the backend."]);
    exit;
}

echo $response;
?>
