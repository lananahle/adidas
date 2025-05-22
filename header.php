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
      padding-top: 100px;
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

    .sidebar .dropdown-content li {
      list-style: none;
      padding-left: 5px;
    }

    .sidebar .dropdown-content li a {
      display: block;
      padding: 8px 24px;
      font-size: 1rem;
      color: #fff;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .sidebar .dropdown-content li a:hover {
      background-color: rgba(255, 255, 255, 0.08);
    }

    .sidebar .nav-list li {
      padding-left: 5px;
      padding-right: 5px;
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

@media (max-width: 768px) {
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
      .nav-list { 
        display: none; 
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
      nav.main-nav {
        top: 40px;
      }
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
        <li class="nav-item"><a href="mailto: lananahle2@gmail.com">Contact Us</a></li>
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
      <li class="nav-item"><a href="mailto: lananahle2@gmail.com">Contact Us</a></li>
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

document.querySelectorAll('.sidebar .nav-item > a, .sidebar .nav-item > button').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.sidebar .nav-item').forEach(i => i.classList.remove('active'));
    item.parentElement.classList.add('active');
  });
});

    </script>

</body>
</html>