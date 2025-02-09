<?php
date_default_timezone_set('Asia/Bangkok');

$con = new mysqli('localhost', 'root', '1234', 'intpro');
if ($con->connect_error) {
    die('Connection Failed: ' . $con->connect_error);
}

if (isset($_POST['title'], $_POST['type'], $_POST['start'], $_POST['end'])) {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    $sql = "INSERT INTO time_table (title, type, start_datetime, end_datetime) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $title, $type, $start, $end);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Event saved successfully']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}

$con->close();
?>
