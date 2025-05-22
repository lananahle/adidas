<?php
include 'db_connection.php';

$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$today = date('Y-m-d');

$where = "WHERE order_status IN ('Confirmed', 'In Progress', 'Shipping', 'Delivered')";

if ($from && $to) {
    $where .= " AND order_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
} elseif ($from && !$to) {
    $where .= " AND order_date BETWEEN '$from 00:00:00' AND '$today 23:59:59'";
} elseif (!$from && $to) {
    $where .= " AND order_date <= '$to 23:59:59'";
} else {
    $where .= " AND order_date BETWEEN '$today 00:00:00' AND '$today 23:59:59'";
}

$query = "SELECT COUNT(*) AS total_orders FROM `order` $where";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

echo $data['total_orders'] ?? 0;
?>
