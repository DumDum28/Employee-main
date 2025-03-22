<?php

session_start();
// กำหนดเขตเวลาให้เป็น Asia/Bangkok เพื่อให้เวลาแสดงผลถูกต้อง
// ป้องกันปัญหาการแสดงเวลาผิดจาก Time Zone ของเซิร์ฟเวอร์
date_default_timezone_set('Asia/Bangkok');  

// เชื่อมต่อฐานข้อมูล (กำหนดค่าของคุณให้ถูกต้อง)
$host = "localhost";
$username = "root";
$password = "1234";
$database = "intpro";

// เชื่อมต่อฐานข้อมูล MySQL
$conn = new mysqli($host, $username, $password, $database); // ใช้ database intpro

// ตรวจสอบการเชื่อมต่อฐานข้อมูล ถ้าล้มเหลวจะแสดงข้อความข้อผิดพลาด
if ($con->connect_error) {
    die(json_encode(['error' => 'Connection Failed: ' . $con->connect_error]));
}

// ตรวจสอบว่า login แล้วหรือยัง
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// สร้างคำสั่ง SQL สำหรับดึงข้อมูลจากฐานข้อมูล
$sql = "
    SELECT 
        ab.ambulance_booking_location AS title,
        'ambulance' AS type,
        CONCAT(ab.ambulance_booking_date, 'T', ab.ambulance_booking_start_time) AS start, 
        CASE 
            WHEN ab.ambulance_booking_fisnish_time IS NULL OR ab.ambulance_booking_fisnish_time = '' 
            THEN CONCAT(ab.ambulance_booking_date, 'T', ADDTIME(ab.ambulance_booking_start_time, '01:00:00')) 
            ELSE CONCAT(ab.ambulance_booking_date, 'T', ab.ambulance_booking_fisnish_time) 
        END AS end
    FROM ambulance_booking ab
    JOIN user_vehicles uv ON ab.vehicle_id = uv.vehicle_id
    WHERE uv.user_id = ?
";

// Execute
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// สร้าง array สำหรับเก็บข้อมูล event
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// ส่งผลลัพธ์เป็น JSON
header('Content-Type: application/json');
echo json_encode($events, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
