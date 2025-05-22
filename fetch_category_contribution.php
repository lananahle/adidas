<?php
include 'db_connection.php';

$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$today = date('Y-m-d');

$where = "WHERE o.order_status IN ('Confirmed', 'In Progress', 'Shipping', 'Delivered')";

if ($from && $to) {
    $where .= " AND o.order_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
} elseif ($from && !$to) {
    $where .= " AND o.order_date >= '$from 00:00:00'";
} elseif (!$from && $to) {
    $where .= " AND o.order_date <= '$to 23:59:59'";
} else {
    $where .= " AND o.order_date BETWEEN '$today 00:00:00' AND '$today 23:59:59'";
}

$totalQuery = "
    SELECT SUM(od.quantity * od.unit_price) AS total_revenue
    FROM order_detail od
    JOIN `order` o ON o.order_id = od.order_id
    $where
";
$totalResult = mysqli_query($conn, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult);
$totalRevenue = $totalData['total_revenue'] ?? 0;

$query = "
    SELECT c.name, SUM(od.quantity * od.unit_price) AS revenue
    FROM order_detail od
    JOIN `order` o ON o.order_id = od.order_id
    JOIN product_variant pv ON pv.variant_id = od.variant_id
    JOIN product p ON p.product_id = pv.product_id
    JOIN category c ON c.category_id = p.category_id
    $where
    GROUP BY c.category_id
    ORDER BY revenue DESC
";

$result = mysqli_query($conn, $query);
$rank = 1;

if (mysqli_num_rows($result) === 0) {
    echo "<li class='text-gray-500'>No sales in selected period.</li>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $percent = $totalRevenue > 0 ? round(($row['revenue'] / $totalRevenue) * 100) : 0;
        echo "<li class='flex items-center gap-2 mb-1'>";
        echo "<span class='w-5 font-semibold text-gray-800'>{$rank}.</span>";
        echo "<span class='flex-1 text-gray-700'>" . htmlspecialchars($row['name']) . "</span>";
        echo "<span class='text-blue-600 font-medium'>{$percent}%</span>";
        echo "</li>";
        $rank++;
    }
}
?>
