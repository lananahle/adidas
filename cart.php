<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

if (!empty($_SESSION['checkout_errors'])) {
  echo '<div class="error">'.implode('<br>', $_SESSION['checkout_errors']).'</div>';
  unset($_SESSION['checkout_errors']);
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'], $_POST['variant_id'])) {
        $variant_id = (int)$_POST['variant_id'];
        $quantity   = max(1, (int)$_POST['quantity']);
        $upd = mysqli_prepare(
            $conn,
            "UPDATE cart SET quantity = ? WHERE user_id = ? AND variant_id = ?"
        );
        mysqli_stmt_bind_param($upd, "iii", $quantity, $user_id, $variant_id);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    } elseif (isset($_POST['remove_item'], $_POST['variant_id'])) {
        $variant_id = (int)$_POST['variant_id'];
        $del = mysqli_prepare(
            $conn,
            "DELETE FROM cart WHERE user_id = ? AND variant_id = ?"
        );
        mysqli_stmt_bind_param($del, "ii", $user_id, $variant_id);
        mysqli_stmt_execute($del);
        mysqli_stmt_close($del);
    }
    header('Location: cart.php');
    exit;
}

$stmt = mysqli_prepare(
  $conn,
  "SELECT c.variant_id, pv.product_id, pv.size, c.quantity, p.name, p.price, p.promotion_price, p.is_on_promotion, p.image_1
   FROM cart c
   JOIN product_variant pv ON c.variant_id = pv.variant_id
   JOIN product p ON pv.product_id = p.product_id
   WHERE c.user_id = ? AND p.is_deleted = 0"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$items  = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

$cart_total = 0;
$savings_total = 0;

foreach ($items as $item) {
    $unit_price = (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1)
                  ? $item['promotion_price']
                  : $item['price'];

    $cart_total += $unit_price * $item['quantity'];

    // Calculate how much was saved
    if (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1) {
        $saved_per_item = ($item['price'] - $item['promotion_price']) * $item['quantity'];
        $savings_total += $saved_per_item;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      color: #333;
    }
    .cart-container {
      max-width: 1000px;
      margin: 20px auto;
      padding: 0 10px;
    }
    h2 {
      margin: 10px 0;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 1.8rem;
    }
    .cart-item {
      display: flex;
      align-items: center;
      background: #fff;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .item-img {
      flex: 0 0 60px;
      margin-right: 10px;
    }
    .item-img img {
      width: 60px;
      border-radius: 4px;
    }
    .item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .item-details .name {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      font-size: 1rem;
      margin: 0 0 4px;
    }
    .item-details .size {
      font-size: 0.85rem;
      color: #555;
      margin-bottom: 6px;
    }
    .quantity-form {
      display: flex;
      align-items: center;
      margin-bottom: 6px;
    }
    .quantity-form input[type="number"] {
      width: 50px;
      padding: 4px;
      margin-right: 8px;
      font-size: 0.9rem;
    }
    .quantity-form button {
      padding: 4px 10px;
      font-size: 0.85rem;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }
    .quantity-form button:hover {
      background: #222;
    }
    .item-total {
      font-size: 0.95rem;
      font-weight: 600;
      margin: 0 10px;
    }
    .remove-btn button {
      background: #f44336;
      color: #fff;
      padding: 4px 10px;
      font-size: 0.85rem;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }
    .remove-btn button:hover {
      background: #d32f2f;
    }
    .cart-summary {
      text-align: right;
      margin: 10px 0;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 1rem;
    }
    .cart-footer {
      text-align: right;
      margin: 5px 0;
    }
    .cart-footer .btn {
      padding: 8px 20px;
      font-size: 0.95rem;
      background: #000;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      display: inline-block;
    }
    .cart-footer .btn:hover {
      background: #222;
    }
    @media (max-width: 480px) {
      .cart-item {
        padding: 8px;
      }
      .item-img {
        flex: 0 0 50px;
        margin-right: 8px;
      }
      .item-img img { width: 50px; }
      .item-details .name { font-size: 0.95rem; }
      .item-details .size { font-size: 0.8rem; }
      .quantity-form input[type="number"] { width: 45px; }
      .quantity-form button {
        padding: 3px 8px;
        font-size: 0.8rem;
        content: '\21bb';
      }
      .remove-btn button {
        padding: 3px 8px;
        font-size: 0.8rem;
        content: '\2715';
      }
      .item-total { font-size: 0.9rem; margin: 0 8px; }
      h2 { font-size: 1.5rem; }
      .cart-summary { font-size: 0.95rem; }
      .cart-footer .btn { width: 100%; text-align: center; padding: 8px 0; }
    }

    .discount {
      color: red;
    }

    .old-price {
    text-decoration: line-through;
    color: #888;
    margin-right: 6px;
}

.new-price {
    color: #d32f2f;
    font-weight: bold;
}


  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="cart-container">
    <h2>My Cart (<?php echo count($items); ?>)</h2>
    <?php if (empty($items)): ?>
      <p>Your cart is empty.</p>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <div class="cart-item">
          <div class="item-img">
            <a href="product.php?id=<?php echo $item['product_id']; ?>&return=cart"><img src="pics/<?php echo htmlspecialchars($item['image_1']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></a>
          </div>
          <div class="item-details">
            <div class="name"><?php echo htmlspecialchars($item['name']); ?></div>
            <div class="size">Size: <?php echo htmlspecialchars($item['size']); ?></div>
            <form class="quantity-form" action="cart.php" method="post">
              <input type="hidden" name="variant_id" value="<?php echo $item['variant_id']; ?>">
              <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
              <button type="submit" name="update_quantity">↻</button>
            </form>
          </div>
          <div class="item-total">
            <?php
              $unit_price = (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1)
                            ? $item['promotion_price']
                            : $item['price'];

              if (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1): ?>
                <span class="old-price">
                  $<?= number_format($item['price'] * $item['quantity'], 2); ?>
                </span>
                <span class="new-price">
                  $<?= number_format($item['promotion_price'] * $item['quantity'], 2); ?>
                </span>
            <?php else: ?>
                $<?= number_format($item['price'] * $item['quantity'], 2); ?>
            <?php endif; ?>
          </div>

          <div class="remove-btn">
            <form action="cart.php" method="post">
              <input type="hidden" name="variant_id" value="<?php echo $item['variant_id']; ?>">
              <button type="submit" name="remove_item">✕</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="cart-summary">
      <div class="cart-total">
        <strong>Total:</strong> $<?php echo number_format($cart_total, 2); ?>
      </div>

      <?php if ($savings_total > 0): ?>
        <div class="cart-savings">
          <strong>You saved:</strong><span class="discount">$<?php echo number_format($savings_total, 2); ?></span>
        </div>
      <?php endif; ?>
    </div>

      <div class="cart-footer">
        <a href="checkout.php" class="btn">Continue to Checkout</a>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
