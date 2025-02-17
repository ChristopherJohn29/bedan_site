<?php
$conn = new mysqli('localhost', 'root', '', 'bedan');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get train status
$query = "SELECT * FROM train_status WHERE train_id = 1";
$result = $conn->query($query);
$train = $result->fetch_assoc();

// If no data found, initialize a record
if (!$train) {
    $conn->query("INSERT INTO train_status (train_id, current_station, direction) VALUES (1, 1, 'FORWARD')");
    $current_station = 1;
    $direction = 'FORWARD';
} else {
    $current_station = $train['current_station'];
    $direction = $train['direction'];
}

// Define station order
$stations = [1, 2, 3];

// Simulated movement
if ($direction == 'FORWARD') {
    if ($current_station >= 3) {
        // If the train reaches station 3, switch direction
        $current_station = 3;
        $direction = 'BACKWARD';
    } else {
        // Move forward to the next station
        $current_station++;
    }
} else { // BACKWARD
    if ($current_station <= 1) {
        // If the train reaches station 1, switch direction
        $current_station = 1;
        $direction = 'FORWARD';
    } else {
        // Move backward to the previous station
        $current_station--;
    }
}

// Update database
$update = "UPDATE train_status SET current_station = '$current_station', direction = '$direction' WHERE train_id = 1";
$conn->query($update);

// Return updated train status
echo json_encode(["current_station" => $current_station, "direction" => $direction]);

?>
