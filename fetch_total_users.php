<?php
include 'db_connection.php';

$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$today = date('Y-m-d');

$where = "WHERE role = 'user'";

if ($from && $to) {
    $where .= " AND DATE(date_joined) BETWEEN '$from' AND '$to'";
} elseif ($from && !$to) {
    $where .= " AND DATE(date_joined) >= '$from'";
} elseif (!$from && $to) {
    $where .= " AND DATE(date_joined) <= '$to'";
} else {
    $where .= " AND DATE(date_joined) = '$today'";
}

$query = "SELECT COUNT(*) AS total_users FROM user $where";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

echo $data['total_users'] ?? 0;
