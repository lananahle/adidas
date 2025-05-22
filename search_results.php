<?php
session_start();
include 'db_connection.php';

$query = $_GET['query'] ?? '';
$results = [];

if ($query !== '') {
    $stmt = mysqli_prepare($conn, "
        SELECT product_id, name, price, promotion_price, is_on_promotion, image_1
        FROM product
        WHERE name LIKE CONCAT('%', ?, '%') AND is_deleted = 0
    ");
    mysqli_stmt_bind_param($stmt, "s", $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      padding: 5px;
      margin: 0;
    }

    h2 {
      font-size: 1.5rem;
      margin-bottom: 20px;
      margin-top: 20px;
    }

    .container {
        padding: 10px;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 20px;
    }

    .product-card {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-decoration: none;
      color: inherit;
      transition: transform 0.2s;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .product-card h3 {
      margin: 10px;
      font-size: 1rem;
    }

    .price, .promotion-price, .old-price {
      display: block;
      margin-bottom: 10px;
    }

    .promotion-price {
      color: red;
      font-weight: bold;
    }

    .old-price {
      color: gray;
      text-decoration: line-through;
      font-size: 0.9rem;
    }

    .no-results {
      font-size: 1.1rem;
      color: #555;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
  <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

  <?php if (empty($results)): ?>
    <p class="no-results">No results match your search.</p>
  <?php else: ?>
    <div class="products-grid">
      <?php foreach ($results as $product): ?>
        <a href="product.php?id=<?php echo $product['product_id']; ?>" class="product-card">
          <img src="pics/<?php echo htmlspecialchars($product['image_1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
          <h3><?php echo htmlspecialchars($product['name']); ?></h3>

          <?php if (!empty($product['is_on_promotion']) && $product['is_on_promotion'] == 1): ?>
            <span class="promotion-price">$<?php echo number_format($product['promotion_price'], 2); ?></span>
            <span class="old-price">$<?php echo number_format($product['price'], 2); ?></span>
          <?php else: ?>
            <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
