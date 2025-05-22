<?php
require_once 'db_connection.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$sales_total = 0;

$today = date('Y-m-d');
$where = "WHERE o.order_status IN ('Confirmed', 'In Progress', 'Shipping', 'Delivered')";
$params = [];
$types = '';

if (!empty($from) && !empty($to)) {
    $where .= " AND o.order_date BETWEEN ? AND ?";
    $params[] = $from . ' 00:00:00';
    $params[] = $to . ' 23:59:59';
    $types .= 'ss';
} elseif (!empty($from)) {
    $where .= " AND o.order_date >= ?";
    $params[] = $from . ' 00:00:00';
    $types .= 's';
} elseif (!empty($to)) {
    $where .= " AND o.order_date <= ?";
    $params[] = $to . ' 23:59:59';
    $types .= 's';
} else {
    $where .= " AND o.order_date BETWEEN ? AND ?";
    $params[] = $today . ' 00:00:00';
    $params[] = $today . ' 23:59:59';
    $types .= 'ss';
}

$query = "
SELECT SUM(o.total_price) AS total_sales
FROM `order` o
$where
";

$stmt = mysqli_prepare($conn, $query);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $sales_total);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

echo number_format($sales_total ?? 0, 2);
?>
