<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['order_id'])) {
    echo "No order selected.";
    exit;
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "
    SELECT order_id, order_date, shipping_address, total_price, order_status
    FROM `order`
    WHERE order_id = ? AND user_id = ?
");
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$order) {
    echo "Order not found or access denied.";
    exit;
}

$stmt = mysqli_prepare($conn, "
    SELECT p.image_1, p.name AS product_name, pv.size, od.unit_price, od.quantity
    FROM order_detail od
    JOIN product_variant pv ON od.variant_id = pv.variant_id
    JOIN product p ON pv.product_id = p.product_id
    WHERE od.order_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "
    SELECT SUM(quantity) AS total_qty
    FROM order_detail
    WHERE order_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result_qty = mysqli_stmt_get_result($stmt);
$qty_row = mysqli_fetch_assoc($result_qty);
$total_quantity = $qty_row['total_qty'] ?? 0;
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #111;
    margin-top: 30px;
    margin-bottom: 30px;
    font-size: 30px;
}

.order-info {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.05);
}

.order-info p {
    margin: 10px 0;
    font-size: 16px;
    color: #333;
}

h2 {
    color: #111;
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 24px;
}

.product-item {
    background: #fefefe;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease;
}

.product-item:hover {
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.product-item img {
    width: 100px;
    height: auto;
    border-radius: 8px;
    margin-right: 20px;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 100%;
}

.product-info p {
    margin: 4px 0;
    font-size: 15px;
    color: #444;
    text-align: left;
}

.back-link {
    display: inline-block;
    margin-top: 5px;
    margin-bottom: 20px;
    text-decoration: none;
    color: #111;
    font-weight: bold;
}

.back-link:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .product-item {
        flex-direction: column;
        align-items: flex-start;
        padding: 15px;
    }

    .product-item img {
        margin-bottom: 15px;
        margin-right: 0;
    }

    .product-info {
        width: 100%;
    }

    .product-info p {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 26px;
    }

    .order-info p {
        font-size: 14px;
    }

    .product-item {
        padding: 10px;
    }
}

</style>

<body>

<?php
    include 'header.php'
?>

<h1>Order Details</h1>

<a class="back-link" href="previous_orders.php">← Back to Orders</a>

<div class="order-info">
    <p><strong>Order #:</strong> <?= $order['order_id'] ?></p>
    <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
    <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>
    <p><strong>Total Quantity:</strong> <?= $total_quantity ?></p>
    <p><strong>Status:</strong> <?= $order['order_status'] ?></p>
</div>

<h2>Products:</h2>

<?php foreach ($order_items as $item): ?>
    <div class="product-item">
        <img src="pics/<?= htmlspecialchars($item['image_1']) ?>" alt="Product Image" width="100">
        <div class="product-info">
            <p><strong>Product:</strong> <?= htmlspecialchars($item['product_name']) ?></p>
            <p><strong>Size:</strong> <?= htmlspecialchars($item['size']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($item['unit_price'], 2) ?></p>
            <p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
            <p><strong>Subtotal:</strong> $<?= number_format($item['unit_price'] * $item['quantity'], 2) ?></p>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
