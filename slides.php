<?php
session_start();
include 'db_connection.php';

$per_page = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$category_name = 'Slides';

$count_stmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) FROM product 
     JOIN category ON product.category_id = category.category_id 
     WHERE category.name = ? AND product.is_deleted = 0"
);
mysqli_stmt_bind_param($count_stmt, "s", $category_name);
mysqli_stmt_execute($count_stmt);
mysqli_stmt_bind_result($count_stmt, $total_products);
mysqli_stmt_fetch($count_stmt);
mysqli_stmt_close($count_stmt);

$data_stmt = mysqli_prepare(
  $conn,
  "SELECT product.product_id, product.name, product.image_1, product.price, product.promotion_price, product.is_on_promotion
   FROM product 
   JOIN category ON product.category_id = category.category_id 
   WHERE category.name = ? AND product.is_deleted = 0
   LIMIT ?, ?"
);

mysqli_stmt_bind_param($data_stmt, "sii", $category_name, $offset, $per_page);
mysqli_stmt_execute($data_stmt);
$result = mysqli_stmt_get_result($data_stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($data_stmt);

$total_pages = ceil($total_products / $per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footwear</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

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
      font-family: 'Poppins', sans-serif;
      background: #f9f9f9;
    }

    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px;
      background: #fff;
    }
    .category-title {
      position: relative;
      font-size: 2rem;
      font-weight: 700;
      text-transform: uppercase;
      cursor: pointer;
    }
    .category-title::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -5px;
      height: 3px;
      width: 0;
      background: #111;
      transition: width 0.4s ease;
    }
    .category-title:hover::after {
      width: 100%;
    }
    .product-count {
      font-size: 1rem;
      color: #555;
      padding-top: 8px;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      grid-gap: 20px;
      padding: 20px;
    }
    .product-card {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
      text-decoration: none;
      color: inherit;
      transition: transform 0.2s;
    }
    .product-card img {
      width: 100%;
      height: auto;
      display: block;
    }
    .product-card .name {
      padding: 10px;
      font-size: 1rem;
    }
    .product-card .price {
      padding-bottom: 10px;
      font-size: 0.9rem;
      color: #888;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }

    .pagination {
      text-align: center;
      margin: 20px 0;
    }
    .pagination a,
    .pagination span {
      display: inline-block;
      margin: 0 5px;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      text-decoration: none;
      color: #333;
    }
    .pagination .current {
      background: #333;
      color: #fff;
      border-color: #333;
    }

    @media (max-width: 768px) {
      .page-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .category-title {
        font-size: 1.5rem;
      }
    }
    @media (max-width: 480px) {
      .category-title {
        font-size: 1.3rem;
      }
      .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        grid-gap: 10px;
        padding: 10px;
      }
    }
    .prices {
    display: flex;
    align-items: center;
    justify-content: center;
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
    line-height: 1;
    white-space: nowrap;
    margin-top: 5px;
}

.out-of-stock-badge {
  position: absolute;
  top: 10px;
  left: 10px;
  background: black;
  color: #fff;
  padding: 4px 8px;
  font-size: 0.75rem;
  font-weight: bold;
  border-radius: 4px;
  box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
  z-index: 10;
}


  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-header">
    <h1 class="category-title">Slides</h1>
    <span class="product-count"><?php echo $total_products; ?> items</span>
  </div>

  <div class="products-grid">
    <?php foreach ($products as $prod):
      $stock_stmt = mysqli_prepare($conn, "
      SELECT COALESCE(SUM(stock_quantity), 0) AS total_stock
      FROM product_variant
      WHERE product_id = ?
      ");
      mysqli_stmt_bind_param($stock_stmt, "i", $prod['product_id']);
      mysqli_stmt_execute($stock_stmt);
      $stock_result = mysqli_stmt_get_result($stock_stmt);
      $stock_data = mysqli_fetch_assoc($stock_result);
      $total_stock = (int)($stock_data['total_stock'] ?? 0);
      mysqli_stmt_close($stock_stmt);
    ?>

    <a href="product.php?id=<?php echo $prod['product_id']; ?>&return=slides&page=<?php echo $page; ?>" class="product-card" style="position: relative;">
      <img src="pics/<?php echo htmlspecialchars($prod['image_1']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>">
      <div class="name"><?php echo htmlspecialchars($prod['name']); ?></div>

      <?php if (!empty($prod['is_on_promotion']) && $prod['is_on_promotion'] == 1): ?>
        <div class="prices">
          <span class="promotion-price">$<?php echo number_format($prod['promotion_price'], 2); ?></span>
          <span class="old-price">$<?php echo number_format($prod['price'], 2); ?></span>
        </div>
        <div class="discount-tag">
          <?php
          $discount = round((($prod['price'] - $prod['promotion_price']) / $prod['price']) * 100);
          echo '-' . $discount . '%';
          ?>
        </div>
      <?php else: ?>
        <div class="price">$<?php echo number_format($prod['price'], 2); ?></div>
      <?php endif; ?>

      <?php if ($total_stock == 0): ?>
        <div class="out-of-stock-badge">Out of Stock</div>
      <?php endif; ?>

    </a>
    <?php endforeach; ?>
  </div>

  <?php if ($total_pages > 1): ?>
    <div class="pagination">
      <?php for ($p = 1; $p <= $total_pages; $p++): ?>
        <?php if ($p === $page): ?>
          <span class="current"><?php echo $p; ?></span>
        <?php else: ?>
          <a href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endif; ?>

  <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="adidasBot"
  agent-id="59558269-3c1a-4489-80ac-8a15a152be07"
  language-code="en"
></df-messenger>


</body>
</html>
