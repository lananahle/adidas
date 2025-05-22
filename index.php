<?php
session_start();
?>

<?php
include 'db_connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adidas | Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
  <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Open Sans', sans-serif; color: #333; }

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
    .logo-container img { height: 35px; }
    .logo-container .brand {
      margin-left: 10px;
      font-size: 22px;
      font-weight: bold;
      text-transform: lowercase;
      letter-spacing: 2px;
      color: #000;
    }

    nav.main-nav {
    position: sticky;
    top: 60px;
    z-index: 1000;
    background: #000;
    }

    .nav-container {
      display: flex;
      align-items: center;
      padding: 15px 20px;
    }
    .menu-toggle {
      display: none;
      flex-direction: column;
      justify-content: space-between;
      width: 25px;
      height: 18px;
      cursor: pointer;
    }
    .menu-toggle span {
      display: block;
      height: 3px;
      background: #fff;
      border-radius: 2px;
    }
    .nav-list {
      display: flex;
      list-style: none;
      margin-left: 20px;
    }
    .nav-item {
      position: relative;
      margin-right: 20px;
    }
    .nav-item > a,
    .nav-item > button {
      color: #fff;
      background: transparent;
      border: none;
      padding: 0 14px;
      height: 36px;
      line-height: 36px;
      font-size: 0.9rem;
      text-transform: uppercase;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.3s;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .nav-item > a:hover,
    .nav-item > button:hover {
      background: #fff;
      color: #000;
      border-radius: 4px;
    }
    .nav-item > button::after {
      content: '▾';
      margin-left: 4px;
      font-size: 0.7em;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #000;
      border-radius: 4px;
      overflow: hidden;
      z-index: 100;
    }
    .dropdown-content.show { display: block; }
    .dropdown-content li a {
      display: block;
      padding: 10px;
      color: #fff;
      text-decoration: none;
      transition: background 0.2s;
    }
    .dropdown-content li a:hover {
      background: #fff;
      color: #000;
    }

    .sidebar {
      display: none;
      position: fixed;
      top: 0;
      left: -280px;
      width: 300px;
      height: 100%;
      background: #000;
      padding-top: 60px;
      transition: left 0.3s;
      z-index: 200;
      padding-top: 110px;
    }
    .sidebar.open { left: 0; }
    .sidebar-close {
      position: absolute;
      top: 16px;
      right: 16px;
      background: none;
      border: none;
      color: #fff;
      font-size: 1.5rem;
      cursor: pointer;
    }
    .sidebar .nav-list {
      display: flex;
      flex-direction: column;
      list-style: none;
    }

    .sidebar .nav-item { 
      margin: 0; 
    }

    .sidebar .nav-item > a,
    .sidebar .nav-item > button {
      display: block;
      width: 100%;
      color: #fff;
      background: transparent;
      border: none;
      font-size: 0.9rem;
      text-align: left;
      text-transform: uppercase;
      cursor: pointer;
      position: relative;
      transition: background-color 0.3s ease;
    }

    .sidebar .nav-item > button::after {
      content: '▾';
      position: absolute;
      right: 0px;
    }

    .sidebar .dropdown-content {
      position: static;
      width: 100%;
      background-color: #000;
      padding: 0;
      margin: 0;
      display: none;
      flex-direction: column;
      box-shadow: none;
      border-radius: 0;
    }

    .sidebar .dropdown-content.show {
      display: flex;
    }

    .sidebar .dropdown-content li a { 
      padding-left: 20px; 
    }

    .sidebar .nav-list li {
      padding-bottom: 5px;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 150;
    }
    .overlay.show { display: block; }

    .banner {
      position: relative;
      width: 100%;
      overflow: hidden;
    }
    .banner video {
      width: 100%;
      height: auto;
      display: block;
    }
    .btn-shop-now {
      position: absolute;
      bottom: 100px;
      padding-left: 20px;
      left: 20px;
      color: #fff;
      font-size: 1.6rem;
      font-weight: bold;
      text-decoration: none;
    }
    .tagline {
      position: absolute;
      bottom: 60px;
      padding-left: 20px;
      left: 20px;
      color: #fff;
      font-family: sans-serif;
      font-size: 1.1rem;
      text-transform: uppercase;
    }

    .best-sellers { 
      padding: 40px 20px; 
    }

    .best-sellers h2 {
      display: inline-block;
      position: relative;
      margin: 0 auto 30px auto;
      font-size: 1.8rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      font-weight: 700;
      color: #111;
      padding-bottom: 10px;
      cursor: default;
    }

    .best-sellers {
      text-align: center;
    }

    .best-sellers h2::after {
      content: '';
      position: absolute;
      height: 3px;
      width: 0;
      background-color: #000;
      left: 50%;
      bottom: 0;
      transform: translateX(-50%);
      transition: width 0.4s ease;
      border-radius: 2px;
    }

    .best-sellers h2:hover::after {
      width: 100%;
    }

    .carousel-container {
      position: relative;
      overflow: visible;
    }
    .products-wrapper {
      overflow: hidden;
    }
    .products-grid {
      display: flex;
      transition: transform 0.3s ease;
    }
    .product-card {
      flex: 0 0 20%;
      padding: 0 10px;
      text-align: center;
    }
    .product-card img {
      width: 100%;
      height: auto;
      border-radius: 4px;
      transition: all 0.3s ease;
    }

    .product-card:hover img {
      padding: 6px;
    }

    .product-card a {
      display: block;
      color: #000;
      text-decoration: none;
      font-weight: 600;
    }
    .product-card h3 {
      margin: 10px 0 5px;
      font-size: 1rem;
    }
    .product-card p {
      font-size: 0.9rem;
      color: #555;
    }

    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(255,255,255,0.9);
      border: none;
      color: #000;
      font-size: 2rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      z-index: 100;
    }

    .carousel-btn.prev { 
      left: 10px; 
    }

    .carousel-btn.next { 
      right: 10px; 
    }

    .carousel-btn[disabled] { 
      opacity: 0.5; cursor: default; 
    }

    .collab-section {
      background-color: #f2f2f2;
      padding: 60px 20px;
    }

    .collab-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 40px;
    }

    .collab-image {
      flex: 1 1 45%;
    }

    .collab-image img {
      width: 100%;
      border-radius: 10px;
      object-fit: cover;
    }

    .collab-text {
      flex: 1 1 50%;
    }

    .collab-text h3 {
      font-size: 1.6rem;
      margin-bottom: 15px;
      color: #111;
    }

    .collab-text p {
      font-size: 1rem;
      color: #444;
      line-height: 1.6;
    }

    .shop-category-section {
      padding: 60px 20px;
      background-color: #fff;
      text-align: center;
    }

    .shop-category-section h2 {
      font-size: 1.8rem;
      text-transform: uppercase;
      font-weight: 700;
      margin-bottom: 40px;
      display: inline-block;
      position: relative;
      cursor: default;
    }

    .shop-category-section h2::after {
      content: '';
      position: absolute;
      width: 0;
      height: 3px;
      background: #000;
      left: 50%;
      bottom: -10px;
      transform: translateX(-50%);
      transition: width 0.4s ease;
      border-radius: 2px;
    }

    .shop-category-section h2:hover::after {
      width: 100%;
    }

    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .category-card {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .category-card:hover {
      transform: scale(1.02);
    }

    .category-card video {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
    }

    .category-label {
      margin-top: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #111;
      text-transform: uppercase;
      letter-spacing: 1px;
      background: #f2f2f2;
      padding: 10px 15px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      display: inline-block;
    }

    .category-card:hover .category-label {
      background: #000;
      color: #fff;
    }

    .site-footer {
      background-color: #000;
      color: #fff;
      padding: 30px 20px;
      text-align: center;
      font-size: 0.95rem;
      margin-top: 60px;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-links {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: #fff;
      text-decoration: none;
      margin: 0 12px;
      font-weight: 500;
      transition: color 0.3s;
    }

    .footer-links a:hover {
      color: #ccc;
    }

    .footer-copy {
      font-size: 0.85rem;
      color: #bbb;
    }

    html {
      scroll-behavior: smooth;
    }

#toast {
  visibility: hidden;
  min-width: 200px;
  background: rgba(0,0,0,0.8);
  color: #fff;
  text-align: center;
  border-radius: 4px;
  padding: 12px;
  position: fixed;
  top: 80px;   
  right: 30px;
  z-index: 9999;  
  font-size: 0.9rem;
  opacity: 0;
}
#toast.show {
  visibility: visible;
  animation: fadein 0.4s, fadeout 0.4s 15s;
}
@keyframes fadein {
  from { opacity: 0; top: 10px; }
  to   { opacity: 1; top: 30px; }
}
@keyframes fadeout {
  from { opacity: 1; top: 30px; }
  to   { opacity: 0; top: 10px; }
}

    @media (max-width: 1024px) {
      .product-card { 
        flex: 0 0 25%; 
      }
    }
    
    @media (max-width: 768px) {
      .best-sellers h2,
      .shop-category-section h2 {
        font-size: 1.3rem; 
        margin-bottom: 1rem; 
      }
      .carousel-btn {
        width: 35px;            
        height: 35px;
        font-size: 1.5rem;    
      }
      header {
        padding: 8px;        
      }
      .logo-container img {
        height: 30px;          
      }
      .logo-container .brand {
        font-size: 18px;         
        letter-spacing: 1.5px;  
      }
      .sidebar {
        width: 200px;      
        left: -200px;       
        display: block;
      }
      .nav-container {
        padding: 8px 15px;  
        top: 40px;
      }
      .nav-item > a,
      .nav-item > button {
        height: 30px;     
        line-height: 30px;
        font-size: 0.8rem;  
        padding: 0 10px;     
      }
      .menu-toggle {
        width: 20px;
        height: 15px;   
        display: flex;
      }
      .menu-toggle span {
        height: 2px; 
      }  
      .banner .btn-shop-now {
        font-size: 1rem;
        bottom: 60px;
        padding-left: 12px;
      }
      .banner .tagline {
        font-size: 0.75rem;
        bottom: 40px;
        padding-left: 12px;
      }
      .nav-list { 
        display: none; 
      }
      .product-card { 
        flex: 0 0 33.333%; 
      }
      .collab-container {
        flex-direction: column;
        text-align: center;
      }
    }

    @media (min-width: 481px) and (max-width: 768px) {
      nav.main-nav {
        top: 50px;
      }
      .menu-toggle {
        width: 22px;
        height: 16px;
      }
      .menu-toggle span {
        height: 2px;
        margin: 2px 0;
      }
    }

    @media (max-width: 480px) {
      .best-sellers h2,
      .shop-category-section h2,
      .collab-text h3 {
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
      }
      .carousel-btn {
        width: 28px;
        height: 28px;
        font-size: 1.2rem;
      }
      header {
        padding: 6px; 
      }
      .logo-container img {
        height: 25px; 
      }
      .logo-container .brand {
        font-size: 16px;    
        letter-spacing: 1px;
      }
      .sidebar {
        width: 160px;        
        left: -160px;
      }
      .sidebar .dropdown-content li {
        padding-left: 20px;
      }
      .sidebar .dropdown-content li a{
        padding-left: 20px;
      }
      .nav-container {
        padding: 6px 10px;
      }
      .nav-item > a,
      .nav-item > button {
        height: 28px;
        line-height: 28px;
        font-size: 0.75rem;
        padding: 0 8px;
      }
      .menu-toggle {
        width: 18px;
        height: 12px;
      }
      .menu-toggle span {
        height: 1.5px;
        margin: 1.5px 0;
      }
      .banner .btn-shop-now {
        font-size: 0.75rem;
        bottom: 50px;
        padding-left: 8px;
      }
      .banner .tagline {
        font-size: 0.5rem;
        bottom: 30px;
        padding-left: 12px;
      }
      nav.main-nav {
        top: 40px;
      }
      .product-card { 
        flex: 0 0 50%; 
      }

      }

    .promotion-section {
  margin: 50px 20px;
  padding: 20px;
  background: #f7f7f7;
  border-radius: 10px;
}

.promotion-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 10px;
}

.promo-icon {
  color: red;
  font-size: 24px;
}

.promo-title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}

.promotion-header h2 {
    font-size: 28px;
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.view-all-button {
  font-size: 15px;
  background-color: #ff6b6b;
  color: white;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: bold;
  text-decoration: none;
  white-space: nowrap;
  transition: background-color 0.3s, transform 0.3s;
}

.view-all-button:hover {
  background-color: #ff4040;
  transform: translateY(-2px);
}

.promotion-swiper {
  width: 100%;
  padding-bottom: 20px;
}

.swiper-wrapper {
  display: flex;
}

.swiper-slide {
  width: auto !important;
  flex-shrink: 0;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}

.promotion-products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    justify-content: center;
    padding-top: 20px;
}

.promotion-product-card {
  width: 210px;
}

.promotion-product-card:hover {
    transform: translateY(-5px);
}

.promotion-product-card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  background: #f0f0f0;
  padding: 10px;
  border-radius: 6px;
}

.promotion-product-card h3 {
  font-size: 16px;
  margin: 8px 0 4px 0;
  color: black;
  text-align: center;
}

.promotion-product-card h3 a:hover {
  color: #ff6b6b;
  text-decoration: underline;
}

a {
  text-decoration: none;
}

.prices {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
  margin-top: 4px;
}

.promotion-price {
  color: red;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
}

.old-price {
  color: gray;
  text-decoration: line-through;
  font-size: 14px;
}

.discount-tag {
  background-color: red;
  color: white;
  font-size: 12px;
  font-weight: bold;
  padding: 2px 6px;
  border-radius: 4px;
  display: inline-block;
  margin-top: 6px;
  left: 50%;
  transform: translateX(-50%);
  position: relative; 
}

.discount-tag1 {
  background-color: red;
  color: white;
  font-size: 12px;
  font-weight: bold;
  padding: 2px 6px;
  border-radius: 4px;
  display: inline-block;
  margin-top: 6px;
}

@media (max-width: 1200px) {
    .promotion-products {
        grid-template-columns: repeat(5, 1fr);
    }
}
@media (max-width: 1000px) {
    .promotion-products {
        grid-template-columns: repeat(4, 1fr);
    }
}
@media (max-width: 768px) {
    .promotion-products {
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 480px) {
    .promotion-products {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
  .promotion-product-card {
    width: 160px;
    padding: 10px;
  }

  .promo-title {
    font-size: 18px;
  }

  .view-all-button {
    font-size: 13px;
    padding: 6px 10px;
  }
}

.promotion-products a {
  text-decoration: none;
  color: #000;
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

.search-container {
  position: relative;
  margin-left: auto;
  margin-right: 20px;
  display: flex;
  align-items: center;
}

#search-box {
  width: 0;
  opacity: 0;
  margin-left: 10px;
  padding: 6px 10px;
  font-size: 0.95rem;
  border-radius: 4px;
  border: none;
  background: white;
  transition: width 0.5s ease-in-out, opacity 0.5s ease-in-out;
  overflow: hidden;
  max-width: 90vw;
  z-index: 1000;
  position: relative;
}

#search-icon {
  background: none;
  border: none;
  font-size: 1.4rem;
  cursor: pointer;
  color: #fff;
}

#search-box.show {
  width: 250px;
  opacity: 1;
}

@media (max-width: 768px) {
  #search-box.show {
    width: 180px;
  }
}
@media (max-width: 480px) {
  #search-box.show {
    width: 140px;
  }
}

#search-suggestions {
  position: absolute;
  top: 100%;
  left: 30px;
  background: #fff;
  width: 100%;
  border: 1px solid #ccc;
  border-top: none;
  border-radius: 0 0 4px 4px;
  max-height: 250px;
  overflow-y: auto;
  display: none;
  z-index: 1001;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

#search-suggestions a {
  display: block;
  padding: 8px 12px;
  text-decoration: none;
  color: #333;
  font-size: 0.9rem;
  border-bottom: 1px solid #eee;
}

#search-suggestions a:hover {
  background: #f2f2f2;
}

.no-results {
  padding: 10px;
  color: #777;
  font-size: 0.9rem;
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

  <?php if (isset($_GET['logged_out'])): ?>
    <div id="toast">You have been logged out.</div>
  <?php endif; ?>

  <nav class="main-nav">
    <div class="nav-container">
      <div class="menu-toggle" id="menuToggle">
        <span></span><span></span><span></span>
      </div>
      <ul class="nav-list">
        <li class="nav-item dropdown">
          <button class="dropbtn">Menu</button>
          <ul class="dropdown-content">
            <li><a href="footwear.php">Footwear</a></li>
            <li><a href="clothing.php">Clothing</a></li>
            <li><a href="slides.php">Slides</a></li>
            <li><a href="accessories.php">Accessories</a></li>
          </ul>
        </li>
        <li class="nav-item"><a href="index.php">Home</a></li>
        <li class="nav-item"><a href="about.php">About</a></li>
        <li class="nav-item"><a href="mailto:lananahle2@gmail.com">Contact Us</a></li>
        <li class="nav-item dropdown">
          <button class="dropbtn">Profile</button>
          <ul class="dropdown-content">
          <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="wishlist.php">Wishlist</a></li>
          <li><a href="previous_orders.php">Previous Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
          <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
          <?php endif; ?>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?php echo isset($_SESSION['user_id']) ? 'cart.php' : 'require_login.php'; ?>">Cart</a>
        </li>
      </ul>
      <div class="search-container">
        <button id="search-icon" aria-label="Search">
          <img src="https://cdn-icons-png.flaticon.com/512/482/482631.png" alt="Search" style="width:20px; height:20px; filter: brightness(0) invert(1);">
        </button>
        <input type="text" id="search-box" placeholder="Search products..." autocomplete="off">
        <div id="search-suggestions"></div>
      </div>
    </div>
  </nav>

  <div class="sidebar" id="sidebar">
    <button class="sidebar-close" id="sidebarClose">×</button>
    <ul class="nav-list">
      <li class="nav-item dropdown">
        <button class="dropbtn">Menu</button>
        <ul class="dropdown-content">
          <li><a href="footwear.php">Footwear</a></li>
          <li><a href="clothing.php">Clothing</a></li>
          <li><a href="slides.php">Slides</a></li>
          <li><a href="accessories.php">Accessories</a></li>
        </ul>
      </li>
      <li class="nav-item"><a href="index.php">Home</a></li>
      <li class="nav-item"><a href="about.php">About</a></li>
      <li class="nav-item"><a href="mailto:lananahle2@gmail.com">Contact Us</a></li>
      <li class="nav-item dropdown">
        <button class="dropbtn">Profile</button>
          <ul class="dropdown-content">
          <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="wishlist.php">Wishlist</a></li>
          <li><a href="previous_orders.php">Previous Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
          <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
          <?php endif; ?>
          </ul>
      </li>
      <li class="nav-item">
          <a href="<?php echo isset($_SESSION['user_id']) ? 'cart.php' : 'require_login.php'; ?>">Cart</a>
        </li>
    </ul>
  </div>
  <div class="overlay" id="overlay"></div>

  <section class="banner">
    <video autoplay muted loop playsinline poster="img/banner-fallback.jpg" preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;">
      <source src="banner/adidas Official Online Store   adidas Lebanon (1).mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <a href="#shop" class="btn-shop-now">SHOP NOW</a>
    <div class="tagline">THE BRAND WITH THE THREE STRIPES</div>
  </section>

  <section class="best-sellers">
  <h2>Best Selling Products</h2>
  <div class="carousel-container">
    <button class="carousel-btn prev" aria-label="Previous">&#10094;</button>
    <div class="products-wrapper">
      <div class="products-grid">
        <?php
          $sql = "
            SELECT p.product_id, p.name, p.price, p.promotion_price, p.is_on_promotion, p.image_1 AS image_url,
                   SUM(od.quantity) AS total_sold
            FROM product p
            JOIN product_variant pv ON pv.product_id = p.product_id
            JOIN order_detail od ON od.variant_id = pv.variant_id
            WHERE is_deleted = 0
            GROUP BY p.product_id, p.name, p.price, p.promotion_price, p.is_on_promotion, p.image_1
            ORDER BY total_sold DESC
            LIMIT 10
          ";
          $result = mysqli_query($conn, $sql);
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $stock_stmt = mysqli_prepare($conn, "
                SELECT COALESCE(SUM(stock_quantity), 0) AS total_stock
                FROM product_variant
                WHERE product_id = ?
              ");
              mysqli_stmt_bind_param($stock_stmt, "i", $row['product_id']);
              mysqli_stmt_execute($stock_stmt);
              $stock_result = mysqli_stmt_get_result($stock_stmt);
              $stock_data = mysqli_fetch_assoc($stock_result);
              $total_stock = (int)($stock_data['total_stock'] ?? 0);
              mysqli_stmt_close($stock_stmt);
        ?>
          <div class="product-card" style="position: relative;">
            <a href="product.php?id=<?= $row['product_id']; ?>">
              <img src="pics/<?= htmlspecialchars($row['image_url']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
              <h3><?= htmlspecialchars($row['name']); ?></h3>

              <?php if (!empty($row['is_on_promotion']) && $row['is_on_promotion'] == 1): ?>
                <div class="prices">
                  <span class="promotion-price">$<?= number_format($row['promotion_price'], 2); ?></span>
                  <span class="old-price">$<?= number_format($row['price'], 2); ?></span>
                  <div class="discount-tag1">
                    <?= '-' . round((($row['price'] - $row['promotion_price']) / $row['price']) * 100) . '%' ?>
                  </div>
                </div>
              <?php else: ?>
                <p class="price">$<?= number_format($row['price'], 2); ?></p>
              <?php endif; ?>

              <?php if ($total_stock == 0): ?>
                <div class="out-of-stock-badge">Out of Stock</div>
              <?php endif; ?>

            </a>
          </div>
        <?php
            }
          } else {
            echo '<p>No best sellers available.</p>';
          }
        ?>
      </div>
    </div>
    <button class="carousel-btn next" aria-label="Next">&#10095;</button>
  </div>
</section>

<section class="promotion-section">
  <div class="promotion-header">
    <h2><span class="promo-icon">&#128722;</span> <span class="promo-title">Current Promotions</span></h2>
    <a href="promotion.php" class="view-all-button">View All</a>
  </div>

  <div class="swiper promotion-swiper">
    <div class="swiper-wrapper">
      <?php
        $query = "SELECT * FROM product WHERE is_on_promotion = 1 AND is_deleted = 0 LIMIT 7";
        $result = mysqli_query($conn, $query);
        while ($product = mysqli_fetch_assoc($result)) {
          $discount = round((($product['price'] - $product['promotion_price']) / $product['price']) * 100);
          $stock_stmt = mysqli_prepare($conn, "SELECT COALESCE(SUM(stock_quantity), 0) AS total_stock FROM product_variant WHERE product_id = ?");
          mysqli_stmt_bind_param($stock_stmt, "i", $product['product_id']);
          mysqli_stmt_execute($stock_stmt);
          $stock_result = mysqli_stmt_get_result($stock_stmt);
          $stock_data = mysqli_fetch_assoc($stock_result);
          $total_stock = (int)($stock_data['total_stock'] ?? 0);
          mysqli_stmt_close($stock_stmt);
      ?>
      <div class="swiper-slide">
        <a href="product.php?id=<?= $product['product_id']; ?>" class="promotion-product-card">
          <div class="promotion-card-content">
            <img src="pics/<?= htmlspecialchars($product['image_1']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p class="prices">
              <span class="promotion-price">$<?= number_format($product['promotion_price'], 2); ?></span>
              <span class="old-price">$<?= number_format($product['price'], 2); ?></span>
            </p>
            <div class="discount-tag">-<?= $discount; ?>%</div>
            <?php if ($total_stock == 0): ?>
              <div class="out-of-stock-badge">Out of Stock</div>
            <?php endif; ?>
          </div>
        </a>
      </div>
      <?php } ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>

<section class="collab-section">
  <div class="collab-container">
    <div class="collab-image">
      <img src="pics/adidasxGUCCI.GIF" alt="Collaboration with Designer X">
    </div>
    <div class="collab-text">
      <h3>Latest Collaboration: Adidas × GUCCI</h3>
      <p>Discover the ultimate fusion of sports and luxury with the adidas x Gucci collaboration. This collaboration pushes boundaries and redefines what it means to move with style.</p>
      <p>Elevate your style with iconic sport shoes and apparel.</p>
    </div>
  </div>
</section>

<section id="shop" class="shop-category-section">
  <h2>Shop by Category</h2>
  <div class="category-grid">
    <a href="footwear.php" class="category-card">
      <video autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;">
        <source src="videos/Samba_OG_Shoes_White.mp4" type="video/mp4">
      </video>
      <div class="category-label">Footwear</div>
    </a>
    <a href="clothing.php" class="category-card">
      <video video autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;">
        <source src="videos/Firebird_Loose_Track_Pants.mp4" type="video/mp4">
      </video>
      <div class="category-label">Clothing</div>
    </a>
    <a href="slides.php" class="category-card">
      <video video autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;">
        <source src="videos/Adilette_Lite_Slides.mp4" type="video/mp4">
      </video>
      <div class="category-label">Slides</div>
    </a>
    <a href="accessories.php" class="category-card">
      <video video autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;">
        <source src="videos/Crew_Socks_2_Pairs.mp4" type="video/mp4">
      </video>
      <div class="category-label">Accessories</div>
    </a>
  </div>
</section>

<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="adidasBot"
  agent-id="59558269-3c1a-4489-80ac-8a15a152be07"
  language-code="en"
></df-messenger>

<script>

  document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 10000);
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

    (function() {
      const grid  = document.querySelector('.products-grid');
      const prev  = document.querySelector('.carousel-btn.prev');
      const next  = document.querySelector('.carousel-btn.next');
      const cards = grid.children;
      let index   = 0;

      function update() {
        const wrapper      = document.querySelector('.products-wrapper');
        const wrapperWidth = wrapper.offsetWidth;
        const cardWidth    = cards[0].offsetWidth + 20;
        const visible      = Math.floor(wrapperWidth / cards[0].offsetWidth);
        prev.disabled      = index === 0;
        next.disabled      = index >= cards.length - visible;
        grid.style.transform = `translateX(-${index * cardWidth}px)`;
      }

      prev.addEventListener('click', () => {
        if (index > 0) index--;
        update();
      });
      next.addEventListener('click', () => {
        const wrapper      = document.querySelector('.products-wrapper');
        const visible      = Math.floor(wrapper.offsetWidth / cards[0].offsetWidth);
        if (index < cards.length - visible) index++;
        update();
      });

      window.addEventListener('resize', update);
      window.addEventListener('load', update);
    })();

    document.addEventListener('DOMContentLoaded', () => {
  const searchIcon = document.getElementById('search-icon');
  const searchBox = document.getElementById('search-box');
  const searchSuggestions = document.getElementById('search-suggestions');

  searchIcon.addEventListener('click', () => {
    searchBox.classList.toggle('show');
    if (searchBox.classList.contains('show')) {
      searchBox.focus();
    } else {
      searchSuggestions.style.display = 'none';
    }
  });

  searchBox.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length === 0) {
      searchSuggestions.innerHTML = '';
      searchSuggestions.style.display = 'none';
      return;
    }

    fetch('search_suggestions.php?term=' + encodeURIComponent(query))
      .then(response => response.json())
      .then(data => {
        searchSuggestions.innerHTML = '';
        if (data.length > 0) {
          data.forEach(item => {
            const link = document.createElement('a');
            link.href = 'product.php?id=' + item.product_id;
            link.innerHTML = `
              <div style="display: flex; align-items: center;">
                <img src="pics/${item.image_1}" alt="${item.name}" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 4px;">
                <span>${item.name}</span>
              </div>
            `;
            searchSuggestions.appendChild(link);
          });
          searchSuggestions.dataset.hasResults = "true";
        } else {
          searchSuggestions.innerHTML = '<div class="no-results">No results match your search</div>';
          searchSuggestions.dataset.hasResults = "false";
        }
        searchSuggestions.style.display = 'block';
      });
  });

  searchBox.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const query = this.value.trim();
      if (query.length > 0 && searchSuggestions.dataset.hasResults === "true") {
        window.location.href = 'search_results.php?query=' + encodeURIComponent(query);
      }
    }
  });
});
  </script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.promotion-swiper', {
  slidesPerView: 'auto',
  spaceBetween: 12,
  grabCursor: true,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
});

</script>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="mailto:info@adidas.com">Contact</a>
    </div>
    <div class="footer-copy">
      &copy; <?php echo date('Y'); ?> adidas. All rights reserved.
    </div>
  </div>
</footer>

</body>
</html>
