<?php
include 'db_connection.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;

$query = "
  SELECT p.name, p.image_1, SUM(pv.stock_quantity) AS total_quantity
    FROM product_variant pv
    JOIN product p ON pv.product_id = p.product_id
    GROUP BY p.product_id
    HAVING total_quantity < 6
    ORDER BY total_quantity ASC
";

if ($limit) {
  $query .= " LIMIT $limit";
}

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  echo '<li class="flex items-center gap-3 mb-2">';
  echo '<img src="pics/' . htmlspecialchars($row['image_1']) . '" class="w-10 h-10 object-cover rounded" alt="product">';
  echo '<span>' . htmlspecialchars($row['name']) . '</span>';
  echo '<span class="ml-auto text-red-600 font-medium">Qty: ' . $row['total_quantity'] . '</span>';
  echo '</li>';
}
?>
