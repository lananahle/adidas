<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "
    SELECT order_id, order_date, shipping_address, total_price, order_status
    FROM `order`
    WHERE user_id = ?
    ORDER BY order_date DESC
");

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    margin-bottom: 40px;
    font-size: 32px;
    margin-top: 40px;
}

.order-summary {
    background: #fff;
    border-radius: 10px;
    padding: 25px 30px;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
    transition: box-shadow 0.3s ease;
}

.order-summary:hover {
    box-shadow: 0px 6px 16px rgba(0,0,0,0.1);
}

.order-summary p {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.order-summary p strong {
    color: #111;
    font-weight: 600;
}

.order-summary button {
    position: absolute;
    top: 20px;
    right: 30px;
    background-color: #111;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.2s;
}

.order-summary button:hover {
    background-color: #333;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .order-summary {
        padding: 20px;
    }

    .order-summary button {
        position: static;
        width: 100%;
        margin-top: 15px;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 26px;
        margin-top: 40px;
    }

    .order-summary p {
        font-size: 15px;
    }
}


</style>

<body>

<?php
    include 'header.php'
?>

<h1>Previous Orders</h1>

<?php if (empty($orders)): ?>
    <p>You have no previous orders.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
    <?php
    $qty_stmt = mysqli_prepare($conn, "
        SELECT SUM(quantity) AS total_qty
        FROM order_detail
        WHERE order_id = ?
    ");
    mysqli_stmt_bind_param($qty_stmt, "i", $order['order_id']);
    mysqli_stmt_execute($qty_stmt);
    $qty_result = mysqli_stmt_get_result($qty_stmt);
    $qty_data = mysqli_fetch_assoc($qty_result);
    $total_quantity = $qty_data['total_qty'] ?? 0;
    mysqli_stmt_close($qty_stmt);
    ?>
    
    <div class="order-summary">
        <p><strong>Order #:</strong> <?= $order['order_id'] ?></p>
        <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
        <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>
        <p><strong>Total Quantity:</strong> <?= $total_quantity ?></p>
        <p><strong>Status:</strong> <?= $order['order_status'] ?></p>

        <form action="order_details.php" method="GET">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
            <button type="submit">View Details</button>
        </form>
    </div>

<?php endforeach; ?>

<?php endif; ?>
</body>
</html>