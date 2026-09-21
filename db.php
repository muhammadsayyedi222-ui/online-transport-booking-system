<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'transport_booking';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
session_start();
?>
