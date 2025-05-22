<?php
session_start();
include 'db_connection.php';

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header('Location: index.php');
    exit;
}
$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'] ?? null;

$order_stmt = mysqli_prepare(
    $conn,
    "SELECT o.order_date, o.total_price, o.payment_method, o.shipping_address, u.name
     FROM `order` o
     JOIN user u ON o.user_id = u.user_id
     WHERE o.order_id = ?"
);
mysqli_stmt_bind_param($order_stmt, "i", $order_id);
mysqli_stmt_execute($order_stmt);
mysqli_stmt_bind_result($order_stmt, $order_date, $total_price, $payment_method, $shipping_address, $customer_name);
if (!mysqli_stmt_fetch($order_stmt)) {
    mysqli_stmt_close($order_stmt);
    header('Location: index.php');
    exit;
}
mysqli_stmt_close($order_stmt);

$items_stmt = mysqli_prepare(
    $conn,
    "SELECT p.name, pv.size, od.quantity, od.unit_price
     FROM order_detail od
     JOIN product_variant pv ON od.variant_id = pv.variant_id
     JOIN product p ON pv.product_id = p.product_id
     WHERE od.order_id = ?"
);
mysqli_stmt_bind_param($items_stmt, "i", $order_id);
mysqli_stmt_execute($items_stmt);
$result = mysqli_stmt_get_result($items_stmt);
$order_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($items_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body { margin: 0; padding: 0; background: #f9f9f9; font-family: 'Poppins', sans-serif; }
    .container { max-width:800px; margin:40px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    h1 { font-weight:700; font-size:2rem; color:#4CAF50; margin-bottom:10px; }
    p { margin:8px 0; }
    .details, .items { margin:20px 0; }
    .items table { width:100%; border-collapse:collapse; }
    .items th, .items td { text-align:left; padding:8px; border-bottom:1px solid #eee; }
    .items th { background:#f5f5f5; }
    .back { display:inline-block; margin-top:20px; text-decoration:none; background:#000; color:#fff; padding:10px 20px; border-radius:4px; margin-left: auto;}
    .back:hover { background:#222; }
    header {
    position: sticky;
    top: 0;
    z-index: 1001;
    background: #fff;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }

  .logo-container {
      display: inline-flex;
      align-items: center;
  }
  
  .logo-container img { 
    height: 35px; 
  }
    
  .logo-container .brand {
    margin-left: 10px;
    font-size: 22px;
    font-weight: bold;
    text-transform: lowercase;
    letter-spacing: 2px;
    color: #000;
  }

  header {
    padding: 15px 20px;
  }
  .logo-container img {
    height: 35px;
  }
  .logo-container .brand {
    font-size: 22px;
    letter-spacing: 2px;
  }

  @media (max-width: 768px) {
    header {
      padding: 10px 13px;
    }
    .logo-container img {
      height: 30px;
    }
    .logo-container .brand {
      font-size: 1.2rem;        
      letter-spacing: 1.5px;
    }
  }

  @media (max-width: 480px) {
    header {
      padding: 8px 10px;
    }
    .logo-container img {
      height: 25px;
    }
    .logo-container .brand {
      font-size: 1rem;         
      letter-spacing: 1px;
    }
  }

  @media (max-width: 768px) {
  .container {
    margin: 20px 10px;
    padding: 15px;
  }
  h1 { font-size: 1.75rem; }
  h2 { font-size: 1.25rem; }
  p, .items th, .items td { font-size: 0.95rem; }
}

@media (max-width: 480px) {
  .container {
    margin: 15px 5px;
    padding: 10px;
  }
  h1 { font-size: 1.5rem; }
  h2 { font-size: 1.1rem; }
  p, .items th, .items td { font-size: 0.85rem; }
  .back {
    width: 100%;
    text-align: center;
    padding: 10px 0;
  }
}


  </style>
</head>
<body>
<header>
    <div class="logo-container">
      <img src="logo/logo-removebg-preview.png" alt="Adidas Logo">
      <span class="brand">adidas</span>
    </div>
  </header>

  <div class="container">
    <h1>Order #<?php echo $order_id; ?> Confirmed</h1>
    <p>Thank you, <?php echo htmlspecialchars($customer_name); ?>!</p>
    <div class="details">
      <p><strong>Date:</strong> <?php echo htmlspecialchars($order_date); ?></p>
      <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($shipping_address); ?></p>
      <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
    </div>
    <div class="items">
      <h2>Order Items</h2>
      <table>
        <thead>
          <tr><th>Product</th><th>Size</th><th>Qty</th><th>Unit Price</th></tr>
        </thead>
        <tbody>
          <?php foreach ($order_items as $it): ?>
            <tr>
              <td><?php echo htmlspecialchars($it['name']); ?></td>
              <td><?php echo htmlspecialchars($it['size']); ?></td>
              <td><?php echo $it['quantity']; ?></td>
              <td>$<?php echo number_format($it['unit_price'],2); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p><strong>Total:</strong> $<?php echo number_format($total_price,2); ?></p>
    <a href="index.php" class="back">Continue Shopping</a>
  </div>
</body>
</html>
