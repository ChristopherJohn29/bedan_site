<?php
$conn = new mysqli('localhost', 'root', 'admin', 'bedan');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the train’s current status
$query = "SELECT * FROM train_status WHERE train_id = 1";
$result = $conn->query($query);
$train = $result->fetch_assoc();

$current_station = $train['current_station'];
$direction = $train['direction'];

// Define station order
$stations = [1, 2, 3];
$turning_point = 'TURN';

// Simulated update mechanism
if ($direction == 'FORWARD') {
    if ($current_station == 3) {
        $current_station = $turning_point;
        $direction = 'BACKWARD';
    } else {
        $current_station++;
    }
} else { // BACKWARD
    if ($current_station == 1) {
        $current_station = $turning_point;
        $direction = 'FORWARD';
    } else {
        $current_station--;
    }
}

// Update database
$update = "UPDATE train_status SET current_station = '$current_station', direction = '$direction' WHERE train_id = 1";
$conn->query($update);

echo json_encode(["current_station" => $current_station, "direction" => $direction]);
?>
