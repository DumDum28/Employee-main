<?php
date_default_timezone_set('Asia/Bangkok');

// เชื่อมต่อฐานข้อมูล
$con = new mysqli('localhost', 'root', '1234', 'intpro');
if ($con->connect_error) {
    die(json_encode(['error' => 'Connection Failed: ' . $con->connect_error]));
}

// ดึงข้อมูลจากสองตาราง
$sql = "
    SELECT 
        ambulance_booking_location AS title,
        'ambulance' as type,
        CONCAT(ambulance_booking_date, 'T', ambulance_booking_start_time) AS start, 
        CONCAT(ambulance_booking_date, 'T', ambulance_booking_fisnish_time) AS end
    FROM ambulance_booking

    UNION

    SELECT 
        event_booking_location AS title, 
        'event' as type,
        CONCAT(event_booking_date, 'T', event_booking_start_time) AS start, 
        CONCAT(event_booking_date, 'T', event_booking_finish_time) AS end
    FROM event_booking

    UNION

    SELECT title, 
           type,
           start_datetime AS start, 
           end_datetime AS end
    FROM time_table
";

$result = $con->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Query Failed: ' . $con->error]));
}

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => $row['title'],
            'start' => $row['start'],
            'end' => $row['end'],
            'type' => $row['type'],
            'allDay' => false
        ];
    }
}

$con->close();

// ส่งข้อมูลกลับในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($events, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
