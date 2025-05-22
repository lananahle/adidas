<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_id'], $_POST['new_status'])) {
    die('Invalid request.');
}

$order_id = (int)$_POST['order_id'];
$new_status_raw = $_POST['new_status'];

$new_status = strtolower(str_replace(' ', '_', $new_status_raw));

$stmt = mysqli_prepare($conn, "SELECT order_status FROM `order` WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $order_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $raw_status);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$current_status = strtolower(str_replace(' ', '_', $raw_status));

$valid_transitions = [
    'pending' => ['confirmed', 'rejected'],
    'confirmed' => ['in_progress'],
    'in_progress' => ['shipping'],
    'shipping' => ['delivered']
];

if (!isset($valid_transitions[$current_status]) || !in_array($new_status, $valid_transitions[$current_status])) {
    die('Invalid status transition.');
}

$formatted_status = ucwords(str_replace('_', ' ', $new_status));

$update_stmt = mysqli_prepare($conn, "UPDATE `order` SET order_status = ? WHERE order_id = ?");
mysqli_stmt_bind_param($update_stmt, 'si', $formatted_status, $order_id);
mysqli_stmt_execute($update_stmt);
mysqli_stmt_close($update_stmt);

header("Location: admin_order_details.php?id=" . $order_id);
exit;
?>
