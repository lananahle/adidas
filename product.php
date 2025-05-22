<?php
session_start();
include 'db_connection.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$return = $_GET['return'] ?? null;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

switch ($return) {
  case 'footwear':
    $backUrl = "footwear.php?page={$page}";
    break;
  case 'clothing':
    $backUrl = "clothing.php?page={$page}";
    break;
  case 'slides':
    $backUrl = "slides.php?page={$page}";
    break;
  case 'accessories':
    $backUrl = "accessories.php?page={$page}";
    break;
  case 'cart':
    $backUrl = "cart.php";
    break;
  case 'wishlist':
    $backUrl = "wishlist.php";
    break;
  default:
    $backUrl = "index.php";
    break;
}

$product_id = intval($_GET['id']);
$product_stmt = mysqli_prepare($conn, "SELECT name, description, price, image_1, is_on_promotion, promotion_price FROM product WHERE product_id = ?");
mysqli_stmt_bind_param($product_stmt, 'i', $product_id);
mysqli_stmt_execute($product_stmt);
$product_result = mysqli_stmt_get_result($product_stmt);
$product = mysqli_fetch_assoc($product_result);
if (!$product) {
    echo '<h2>Product not found.</h2>';
    exit;
}

$variant_stmt = mysqli_prepare($conn, "SELECT variant_id, size, stock_quantity FROM product_variant WHERE product_id = ?");
mysqli_stmt_bind_param($variant_stmt, 'i', $product_id);
mysqli_stmt_execute($variant_stmt);
$variant_result = mysqli_stmt_get_result($variant_stmt);
$variants = mysqli_fetch_all($variant_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($product['name']); ?> | Product Details</title>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 20px;
    }

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

  .back-button {
    display: inline-block;
    margin-top: 20px;
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: 5px;
    padding: 8px 12px;
    background: #eee;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.2s;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .back-button:hover {
    background: #ddd;
    background-color: #000;
    color: white;
  }

  a {
    text-decoration: none;
    color: black;
  }

  @media (max-width: 768px) {
    .back-button {
      margin: 15px;
      padding: 6px 10px;
      font-size: 0.8rem;
    }
  }
  @media (max-width: 480px) {
    .back-button {
      margin: 10px;
      padding: 5px 8px;
      font-size: 0.7rem;
    }
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


  .product-container {
    max-width: 1100px;
    margin: 40px auto;
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    background: #fff;
    padding-left: 20px;
    padding-right: 20px;
    padding-bottom: 20px;
    padding-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  .product-image {
    flex: 1 1 400px;
  }
  .product-image img {
    width: 100%;
    border-radius: 8px;
  }
  .product-details {
    flex: 1 1 300px;
    display: flex;
    flex-direction: column;
  }
  .product-name {
    font-size: 1.8rem;
    margin: 0 0 10px;
    font-weight: bold;
  }
  .product-price {
    font-size: 1.4rem;
    color: #555;
    margin-bottom: 15px;
  }
  .product-description {
    font-size: 1rem;
    color: #444;
    line-height: 1.6;
    margin-bottom: 20px;
  }
  .size-label {
    font-weight: 600;
    margin-bottom: 8px;
  }
  .sizes {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
  }
  .size-btn {
    padding: 10px 16px;
    border: 1px solid #ccc;
    background: #fff;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95rem;
    transition: background 0.3s, color 0.3s;
  }
  .size-btn:not(.active):hover:not([disabled]) {
    background: #000;
    color: #fff;
  }
  .size-btn:disabled {
    background: #eee;
    color: #999;
    cursor: not-allowed;
  }
  .size-btn.active {
    background: #000 !important;
    color: #fff !important;
    border-color: #000 !important;
  }
  .quantity-section {
    margin-bottom: 20px;
  }
  .quantity-section label {
    margin-right: 10px;
    font-weight: 600;
  }
  .quantity-section input[type="number"] {
    width: 60px;
    padding: 8px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  .action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }
  .cart-btn,
  .wishlist-btn {
    flex: 1;
    padding: 12px 0;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
  }
  .cart-btn {
    background: #000;
    color: #fff;
  }
  .cart-btn:hover {
    background: #333;
  }
  .wishlist-btn {
    background: #ddd;
    color: #000;
  }
  .wishlist-btn:hover {
    background: #bbb;
  }
  @media (max-width: 768px) {
    .product-container {
      flex-direction: column;
    }
    .product-image, .product-details {
      flex: 1 1 100%;
    }
  }

  #toast {
    position: fixed;
    top: 80px;        
    right: 20px;
    background: #333;
    color: #fff;
    padding: 8px 12px;
    border-radius: 4px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2000;    
    font-size: 0.9rem;
  }

  #toast.show {
    opacity: 1;
  }

  .promotion-label {
    color: red;
    font-size: medium;
    border-radius: 5px;
    display: inline-block;
    font-weight: bold;
    margin-bottom: 10px;
}

.prices {
    display: flex;
    align-items: center;
    gap: 10px;
}

.promotion-price {
    font-size: 24px;
    color: red;
    font-weight: bold;
}

.old-price {
    font-size: 18px;
    color: gray;
    text-decoration: line-through;
}

.discount {
  margin-top: 5px;
}

.discount-tag {
    display: inline-flex; 
    justify-content: center;
    align-items: center;
    background-color: #e60000;
    color: white;
    font-size: 14px;
    font-weight: bold;
    padding: 4px 6px;
    border-radius: 4px;
    line-height: 1;
    white-space: nowrap;
    height: auto; 
}

.normal-price {
    font-size: 24px;
    color: #333;
    font-weight: bold;
}

.product-description {
    margin-top: 20px;
    font-size: 16px;
    color: #555;
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

  <div id="toast"></div>

<a href="<?php echo htmlspecialchars($backUrl); ?>" class="back-button">← Back</a>


  <div class="product-container">
    <div class="product-image">
      <img src="pics/<?php echo htmlspecialchars($product['image_1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-details">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>

<?php if (isset($product['is_on_promotion']) && (int)$product['is_on_promotion'] === 1) : ?>
    <div class="promotion-label">On Promotion</div>
    <div class="prices">
        <span class="promotion-price">$<?php echo number_format($product['promotion_price'], 2); ?></span>
        <span class="old-price">$<?php echo number_format($product['price'], 2); ?></span>
    </div>
    <div class="discount">
      <span class="discount-tag">
          <?php
          $discount = round((($product['price'] - $product['promotion_price']) / $product['price']) * 100);
          echo '-' . $discount . '%';
          ?>
      </span>
    </div>
<?php else : ?>
    <div class="normal-price">
        $<?php echo number_format($product['price'], 2); ?>
    </div>
<?php endif; ?>



      <div class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
      <form method="post" action="add_to_cart.php" id="cart-form">
        <input type="hidden" name="variant_id" id="variant_id_input" value="">

        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="return" value="<?php echo htmlspecialchars($return); ?>">
        <input type="hidden" name="page"   value="<?php echo htmlspecialchars($page); ?>">


        <div class="size-label">Available Sizes:</div>
        <div class="sizes">
          <?php foreach ($variants as $variant):
            $stock = (int)$variant['stock_quantity'];
          ?><button
            type="button"
            class="size-btn"
            data-variant-id="<?php echo $variant['variant_id']; ?>"
            data-stock="<?php echo $stock; ?>"
            <?php echo $stock > 0 ? '' : 'disabled'; ?>
          >
            <?php echo htmlspecialchars($variant['size']); ?>
          </button>
        
          <?php endforeach; ?>
        </div>

        <div id="stock-warning" style="color: red; font-weight: bold; margin-top: 10px; margin-bottom:10px"></div>

        <div class="quantity-section">
          <label for="quantity">Quantity:</label>
          <input type="number" name="quantity" id="quantity" value="1" min="1">
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="action-buttons">
            <button type="submit" class="cart-btn">Add to Cart</button>
            <button
              type="submit"
              formaction="add_to_wishlist.php"
              class="wishlist-btn"
            >
              Add to Wishlist
            </button>
          </div>
        <?php else: ?>
        <div style="margin-top:20px;">
          <a href="login.php" style="text-decoration:none;color:#000;font-weight:600;">
            Log in to purchase
          </a>
        </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <script>
  
  document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const toast  = document.getElementById('toast');
    let msg = '';

    if      (params.get('added') === 'cart')             msg = 'Item successfully added to cart!';
    else if (params.get('added') === 'wishlist')         msg = 'Item successfully added to wishlist!';
    else if (params.get('added') === 'exists_wishlist')  msg = 'Item is already in your wishlist.';
    
    if (msg) {
      toast.textContent = msg;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2000);
    }
  });


document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const toast  = document.getElementById('toast');
  const productId = params.get('id');
  let msg = '';

  if      (params.get('added') === 'cart')            msg = 'Item successfully added to cart!';
  else if (params.get('added') === 'wishlist')        msg = 'Item successfully added to wishlist!';
  else if (params.get('added') === 'exists_wishlist') msg = 'Item is already in your wishlist.';

  if (msg) {
    toast.textContent = msg;
    toast.classList.add('show');

    history.replaceState({}, '', `${window.location.pathname}?id=${productId}`);

    setTimeout(() => toast.classList.remove('show'), 2000);
  }

  const sizeButtons  = document.querySelectorAll('.size-btn');
  const variantInput = document.getElementById('variant_id_input');
  sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
    sizeButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    variantInput.value = btn.getAttribute('data-variant-id');

    const stockWarning = document.getElementById('stock-warning');
    const stockQty = parseInt(btn.getAttribute('data-stock'));

    if (stockQty === 2) {
      stockWarning.textContent = "Only 2 left!";
    } else if (stockQty === 1) {
      stockWarning.textContent = "Only 1 left!";
    } else {
      stockWarning.textContent = "";
    }
  });

  });

  const cartForm = document.getElementById('cart-form');
  cartForm.addEventListener('submit', function(e) {
    const clicked = e.submitter; 
    if (clicked && clicked.classList.contains('cart-btn')) {
      if (!variantInput.value) {
        e.preventDefault();
        alert('Please select a size before adding to cart.');
      }
    }
  });

    });
    const menuToggle   = document.getElementById('menuToggle');
    const sidebar      = document.getElementById('sidebar');
    const overlay      = document.getElementById('overlay');
    const sidebarClose = document.getElementById('sidebarClose');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    });
    sidebarClose.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
    });
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
    });

    document.querySelectorAll('.nav-item.dropdown').forEach(dd => {
      const btn = dd.querySelector('button');
      btn.addEventListener('click', e => {
        e.stopPropagation();
        const menu = dd.querySelector('.dropdown-content');
        menu.classList.toggle('show');
      });
    });
    window.addEventListener('click', () => {
      document.querySelectorAll('.dropdown-content').forEach(dc => dc.classList.remove('show'));
    });
  

  </script>
</body>
</html>
