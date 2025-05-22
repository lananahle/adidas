<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT c.variant_id,
       pv.size,
       c.quantity AS requested_qty,
       p.price,
       p.promotion_price,
       p.is_on_promotion,
       p.name,
       pv.stock_quantity
       FROM cart c
      JOIN product_variant pv ON c.variant_id = pv.variant_id
      JOIN product p ON pv.product_id = p.product_id
      WHERE c.user_id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    foreach ($cart_items as $item) {
        if ($item['requested_qty'] > $item['stock_quantity']) {
            $msg = "Requested quantity for {$item['name']} ({$item['requested_qty']}) exceeds available stock ({$item['stock_quantity']}).";
            echo "<script>alert(" . json_encode($msg) . "); window.location='cart.php';</script>";
            exit;
        }
    }
}

$cart_total = 0;
foreach ($cart_items as $item) {
    $unit_price = (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1)
                  ? $item['promotion_price']
                  : $item['price'];

    $cart_total += $unit_price * $item['requested_qty'];
}


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone   = trim($_POST['phone']);
    $payment = $_POST['payment_method'] ?? '';

    if (!$name || !$address || !$phone || !$payment) {
        $errors[] = 'All fields are required.';
    }

    if (empty($errors)) {
        $orderStmt = mysqli_prepare(
            $conn,
            "INSERT INTO `order` (user_id, total_price, payment_method, order_date, shipping_address, phone_number)
            VALUES (?, ?, ?, NOW(), ?, ?)"
        );
        mysqli_stmt_bind_param($orderStmt, 'idsss', $user_id, $cart_total, $payment, $address, $phone);
        mysqli_stmt_execute($orderStmt);
        $order_id = mysqli_insert_id($conn);
        mysqli_stmt_close($orderStmt);

        foreach ($cart_items as $item) {
            $detailStmt = mysqli_prepare(
                $conn,
                "INSERT INTO order_detail (order_id, variant_id, quantity, unit_price)
                 VALUES (?, ?, ?, ?)"
            );
            $unit_price = (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1)
              ? $item['promotion_price']
              : $item['price'];
              mysqli_stmt_bind_param(
                  $detailStmt,
                  'iidi',
                  $order_id,
                  $item['variant_id'],
                  $item['requested_qty'],
                  $unit_price
              );

            mysqli_stmt_execute($detailStmt);
            mysqli_stmt_close($detailStmt);

            $stockStmt = mysqli_prepare(
                $conn,
                "UPDATE product_variant SET stock_quantity = stock_quantity - ? WHERE variant_id = ?"
            );
            mysqli_stmt_bind_param($stockStmt, 'ii', $item['requested_qty'], $item['variant_id']);
            mysqli_stmt_execute($stockStmt);
            mysqli_stmt_close($stockStmt);
        }

        $clearStmt = mysqli_prepare($conn, 'DELETE FROM cart WHERE user_id = ?');
        mysqli_stmt_bind_param($clearStmt, 'i', $user_id);
        mysqli_stmt_execute($clearStmt);
        mysqli_stmt_close($clearStmt);

        header("Location: order_confirmation.php?order_id={$order_id}");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body { margin:0; padding:0; background:#f9f9f9; font-family:'Segoe UI',sans-serif; color:#333; }
    .checkout-container { max-width:600px; margin:40px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    h2 { font-family:'Poppins',sans-serif; font-weight:700; font-size:2rem; margin-bottom:20px; }
    .error { color:#f44336; margin-bottom:10px; font-family:'Poppins',sans-serif; }
    label { display:block; margin:12px 0 6px; font-family:'Poppins',sans-serif; font-weight:500; }
    input, select { width:100%; padding:10px; font-size:1rem; border:1px solid #ccc; border-radius:4px; font-family:'Segoe UI',sans-serif; }
    .btn { margin-top:20px; background:#000; color:#fff; border:none; padding:12px; width:100%; font-family:'Poppins',sans-serif; font-weight:500; font-size:1rem; cursor:pointer; border-radius:4px; }
    .btn:hover { background:#222; }
    @media (max-width:768px) { .checkout-container { margin:20px 10px; padding:15px; } h2 { font-size:1.5rem; } input, select, .btn { font-size:0.95rem; padding:8px; } }
    @media (max-width:480px) { .checkout-container { margin:15px 5px; padding:10px; } h2 { font-size:1.3rem; } label { font-size:0.95rem; } input, select { font-size:0.9rem; padding:6px; } .btn { font-size:0.9rem; padding:10px; } }
  </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="checkout-container">
  <h2>Checkout</h2>
  <?php if (!empty($errors)): ?>
    <div class="error"><?php echo implode('<br>', $errors); ?></div>
  <?php endif; ?>
  <form id="checkout-form" method="post" action="checkout.php">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($name ?? ''); ?>">

    <label for="address">Shipping Address</label>
    <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($address ?? ''); ?>">

    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone ?? ''); ?>">

    <label for="payment_method">Payment Method</label>
    <select id="payment_method" name="payment_method" required>
      <option value="">--Select--</option>
      <option value="Cash on Delivery">Cash on Delivery</option>
    </select>

    <button type="submit" class="btn">Confirm Order</button>
  </form>
</div>

<script>
  document.getElementById('checkout-form').addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to confirm your order?')) {
      e.preventDefault();
    }
  });
</script>

</body>
</html>
