<?php
$conn = new mysqli('localhost', 'root', '', 'bedan');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT countdown_time FROM train_countdown WHERE train_id = 1";
$result = $conn->query($query);
$train = $result->fetch_assoc();

if ($train) {
    echo json_encode(["countdown_time" => $train['countdown_time']]);
} else {
    echo json_encode(["countdown_time" => 30]); // Default to 30 if not found
}
?>
