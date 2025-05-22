<?php
include 'db_connection.php';

$limit = (isset($_GET['limit']) && $_GET['limit'] === 'all') ? 20 : 5;
$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$today = date('Y-m-d');

$where = "WHERE o.order_status IN ('Confirmed', 'In Progress', 'Shipping', 'Delivered') AND p.is_deleted = 0";
$params = [];
$types = '';

if ($from && $to) {
    $where .= " AND DATE(o.order_date) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
    $types .= 'ss';
} elseif ($from && !$to) {
    $where .= " AND DATE(o.order_date) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $today;
    $types .= 'ss';
} elseif (!$from && $to) {
    $where .= " AND DATE(o.order_date) <= ?";
    $params[] = $to;
    $types .= 's';
} else {
    $where .= " AND DATE(o.order_date) = ?";
    $params[] = $today;
    $types .= 's';
}

$query = "
    SELECT p.name, p.image_1, SUM(od.quantity) AS total_sold
    FROM order_detail od
    JOIN `order` o ON o.order_id = od.order_id
    JOIN product_variant pv ON od.variant_id = pv.variant_id
    JOIN product p ON pv.product_id = p.product_id
    $where
    GROUP BY p.product_id
    ORDER BY total_sold DESC
    LIMIT ?
";

$params[] = $limit;
$types .= 'i';

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$rank = 1;

if (mysqli_num_rows($result) === 0) {
    echo '<li class="text-gray-500">No best-selling items found for this period.</li>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="flex items-center gap-3 mb-2">';
        echo '<span class="font-semibold w-6 text-center">' . $rank++ . '.</span>';
        echo '<img src="pics/' . htmlspecialchars($row['image_1']) . '" class="w-10 h-10 object-cover rounded" alt="product">';
        echo '<span>' . htmlspecialchars($row['name']) . '</span>';
        echo '</li>';
    }
}

mysqli_stmt_close($stmt);
?>
