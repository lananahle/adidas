<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: require_login.php');
    exit;
}
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$stmt = mysqli_prepare(
  $conn,
  "SELECT p.product_id, p.name, p.price, p.promotion_price, p.is_on_promotion, p.image_1, p.description
   FROM wishlist w
   JOIN product p ON w.product_id = p.product_id
   WHERE w.user_id = ? AND p.is_deleted = 0"
);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Wishlist</title>
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
    h2,
    .item-details .name,
    .remove-btn button {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    .wishlist-container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }
    h2 {
      margin-bottom: 20px;
      font-size: 2rem;
    }
    .wishlist-item {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      background: #fff;
      margin-bottom: 15px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .wishlist-item a {
      display: flex;
      flex: 1;
      text-decoration: none;
      color: inherit;
    }
    .item-img {
      flex: 0 0 80px;
      margin-right: 15px;
    }
    .item-img img {
      width: 80px;
      height: auto;
      border-radius: 5px;
    }
    .item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .item-details .name {
      font-size: 1.1rem;
      margin-bottom: 5px;
    }
    .item-details .description {
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 8px;
      font-family: 'Segoe UI', sans-serif;
    }
    .item-details .price {
      font-size: 1rem;
      color: #111;
      font-weight: 600;
      margin-bottom: 5px;
    }
    .remove-btn {
      flex: 0 0 auto;
      margin-left: auto;
      align-self: flex-end;
    }
    .remove-btn form {
      margin: 0;
    }
    .remove-btn button {
      background: #f44336;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.3s;
    }
    .remove-btn button:hover {
      background: #d32f2f;
    }

    .wishlist-summary {
      font-size: 1rem;
      margin-top: 20px;
      text-align: center;
      font-family: 'Segoe UI', sans-serif;
    }
    
    @media (max-width: 768px) {
      .wishlist-item {
        flex-direction: column;
        align-items: flex-start;
      }
    }
    .prices {
    display: flex;
    justify-content: left;
    align-items: left;
    gap: 8px;
}

.promotion-price {
    color: red;
    font-size: 1rem;
    font-weight: bold;
}

.old-price {
    color: gray;
    font-size: 0.9rem;
    text-decoration: line-through;
}

.discount-tag {
    background-color: red;
    color: white;
    padding: 2px 6px;
    font-size: 0.75rem;
    font-weight: bold;
    border-radius: 4px;
    display: inline-block;
    margin-top: 5px;
}

.out-of-stock-badge {
  color: red;
  font-size: 0.9rem;
  font-weight: bold;
  margin-top: 5px;
  display: inline-block;
}


  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="wishlist-container">
    <h2>My Wishlist (<?php echo count($items); ?>)</h2>
    <?php if (empty($items)): ?>
      <div class="wishlist-summary">Your wishlist is empty.</div>
    <?php else: ?>
      <?php foreach ($items as $item): 
        $stock_stmt = mysqli_prepare($conn, "
        SELECT COALESCE(SUM(stock_quantity), 0) AS total_stock
        FROM product_variant
        WHERE product_id = ?
        ");
        mysqli_stmt_bind_param($stock_stmt, "i", $item['product_id']);
        mysqli_stmt_execute($stock_stmt);
        $stock_result = mysqli_stmt_get_result($stock_stmt);
        $stock_data = mysqli_fetch_assoc($stock_result);
        $total_stock = (int)($stock_data['total_stock'] ?? 0);
        mysqli_stmt_close($stock_stmt);
        ?>
        <div class="wishlist-item">
          <a href="product.php?id=<?php echo $item['product_id']; ?>&return=wishlist" class="item-link">
            <div class="item-img">
              <img src="pics/<?php echo htmlspecialchars($item['image_1']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            </div>
            <div class="item-details">
              <div class="name"><?php echo htmlspecialchars($item['name']); ?></div>

              <?php if ($total_stock == 0): ?>
                <div class="description"><?php echo htmlspecialchars($item['description']); ?></div>

                  <?php if (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1): ?>
                    <div class="prices">
                      <span class="promotion-price">$<?php echo number_format($item['promotion_price'], 2); ?></span>
                      <span class="old-price">$<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                    <div class="discount">
                      <span class="discount-tag">
                      <?php
                      $discount = round((($item['price'] - $item['promotion_price']) / $item['price']) * 100);
                      echo '-' . $discount . '%';
                      ?>
                      </span>
                    </div>
                  <?php else: ?>
                    <div class="price">$<?php echo number_format($item['price'], 2); ?></div>
                  <?php endif; ?>
                  <div class="out-of-stock-badge">
                    <span class="out-of-stock-span">Out of Stock</span>
                  </div>
              <?php else: ?>
                  <div class="description"><?php echo htmlspecialchars($item['description']); ?></div>

                  <?php if (!empty($item['is_on_promotion']) && $item['is_on_promotion'] == 1): ?>
                    <div class="prices">
                      <span class="promotion-price">$<?php echo number_format($item['promotion_price'], 2); ?></span>
                      <span class="old-price">$<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                    <div class="discount">
                      <span class="discount-tag">
                      <?php
                      $discount = round((($item['price'] - $item['promotion_price']) / $item['price']) * 100);
                      echo '-' . $discount . '%';
                      ?>
                      </span>
                    </div>
                  <?php else: ?>
                    <div class="price">$<?php echo number_format($item['price'], 2); ?></div>
                  <?php endif; ?>
              <?php endif; ?>
            </div>

          </a>
          <div class="remove-btn">
            <form action="remove_from_wishlist.php" method="post">
              <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
              <button type="submit">Remove</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</body>
</html>