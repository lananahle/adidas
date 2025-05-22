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

$order_query = "SELECT order_id, total_price FROM `order` $where";
$order_result = mysqli_query($conn, $order_query);

$order_ids = [];
$total_sales = 0.0;

while ($row = mysqli_fetch_assoc($order_result)) {
    $order_ids[] = $row['order_id'];
    $total_sales += $row['total_price'];
}

$total_orders = count($order_ids);
$total_quantity = 0;

if (!empty($order_ids)) {
    $order_ids_str = implode(',', array_map('intval', $order_ids));

    $qty_query = "
        SELECT SUM(quantity) AS total_qty
        FROM order_detail
        WHERE order_id IN ($order_ids_str)
    ";
    $qty_result = mysqli_query($conn, $qty_query);
    $qty_data = mysqli_fetch_assoc($qty_result);
    $total_quantity = $qty_data['total_qty'] ?? 0;
}

$avg_basket = $total_orders > 0 ? number_format($total_sales / $total_orders, 2) : '-';
$avg_price = $total_quantity > 0 ? number_format($total_sales / $total_quantity, 2) : '-';
$upt = $total_orders > 0 ? number_format($total_quantity / $total_orders, 2) : '-';

echo json_encode([
    'avg_basket' => $avg_basket,
    'avg_price' => $avg_price,
    'upt' => $upt,
    'total_qty' => $total_quantity > 0 ? $total_quantity : '-'
]);
?>
