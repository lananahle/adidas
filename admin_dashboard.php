<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }
  </script>
</head>
<body class="bg-gray-100 min-h-screen">
  <?php include 'db_connection.php'; ?>
  
  <header class="flex items-center justify-center bg-white p-4 shadow-md fixed top-0 z-40 w-full min-h-[64px]">
    <div class="flex items-center gap-2">
      <img src="pics/logo.jpg" alt="Logo" class="h-8 w-auto">
      <h1 class="text-xl font-bold">adidas</h1>
    </div>
  </header>

  <nav class="bg-black text-white px-4 py-3 flex flex-col sm:flex-row justify-between items-center gap-2 fixed top-[64px] w-full z-30">
    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:justify-start gap-1">
      <div class="flex justify-between w-full sm:w-auto">
        <button onclick="toggleSidebar()" class="sm:hidden">
          <i class="ph ph-list text-2xl"></i>
        </button>
        <div class="text-sm font-medium sm:hidden">Admin Navigation</div>
      </div>
      <div class="hidden sm:block text-sm font-medium sm:ml-4">Admin Navigation</div>
    </div>
    <div class="flex items-center gap-2 mt-2 sm:mt-0">
      <input type="date" id="fromDate" class="text-black border rounded px-2 py-1" onchange="filterSales(); filterBestsellers(); filterOrders(); filterCategoryContribution(); filterUsers(); filterKPIs()" />
      <span>to</span>
      <input type="date" id="toDate" class="text-black border rounded px-2 py-1" onchange="filterSales(); filterBestsellers(); filterOrders(); filterCategoryContribution(); filterUsers(); filterKPIs()" />
    </div>
  </nav>

  <div class="flex pt-[144px]">
    <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[112px] left-0 transform transition-transform duration-200 ease-in-out z-40 shadow-md pt-8 sm:pt-8 -translate-x-full sm:translate-x-0">
      <nav class="px-4 space-y-4">
        <ul class="space-y-2">
          <li><a href="admin_dashboard.php" class="block p-2 bg-white text-black rounded">Dashboard</a></li>
          <li><a href="add_product.php" class="block p-2 hover:bg-gray-800 rounded">Add Product</a></li>
          <li><a href="update_product.php" class="block p-2 hover:bg-gray-800 rounded">Update Product</a></li>
          <li><a href="view_orders.php" class="block p-2 hover:bg-gray-800 rounded">View Orders</a></li>
          <li><a href="add_admin.php" class="block p-2 hover:bg-gray-800 rounded">Add Admin</a></li>
          <li><a href="admin_logout.php" class="block p-2 hover:bg-gray-800 rounded">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main class="flex-1 w-full transition-all duration-300 ease-in-out ml-0 sm:ml-64 pt-[60px] sm:pt-6 px-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <i class="ph ph-eye text-2xl text-blue-500"></i>
          <div>
            <div class="text-sm text-gray-500">Total Views</div>
            <a href="https://analytics.google.com/analytics/web/#/p488647647/reports" 
              target="_blank" 
              class="text-sm text-blue-600 underline hover:text-blue-800 block mt-2">
              View on Google Analytics →
            </a>
          </div>
        </div>

         <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <i class="ph ph-shopping-cart text-2xl text-green-500"></i>
          <div>
            <div class="text-sm text-gray-500">Total Sales</div>
            <div class="text-xl font-semibold" id="totalSalesAmount">
              <span id="totalSalesAmount">Loading...</span>
            </div>
          </div>
        </div>

        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <i class="ph ph-users text-2xl text-purple-500"></i>
          <div>
          <div class="text-sm text-gray-500">Total Users Joined</div>
            <div class="text-xl font-semibold" id="totalUsers">
            <?php
                $today = date('Y-m-d');
                $query = "SELECT COUNT(*) AS total_users FROM user WHERE role = 'user' AND DATE(date_joined) = '$today'";
                $user_result = mysqli_query($conn, $query);
                $user_data = mysqli_fetch_assoc($user_result);
                echo $user_data['total_users'] ?? 0;
            ?>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <div class="flex items-center gap-2 mb-2">
            <i class="ph ph-graph text-2xl text-blue-600"></i>
            <h2 class="text-lg font-semibold">Sales KPIs</h2>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-2 gap-4 text-sm text-gray-700" id="kpi-section">
            <div>
              <div class="text-xs text-gray-500">Avg Basket Size</div>
              <div class="text-lg font-semibold" id="avgBasket">-</div>
            </div>
            <div>
              <div class="text-xs text-gray-500">Avg Price</div>
              <div class="text-lg font-semibold" id="avgPrice">-</div>
            </div>
            <div>
              <div class="text-xs text-gray-500">Units Per Transaction</div>
              <div class="text-lg font-semibold" id="upt">-</div>
            </div>
            <div>
              <div class="text-xs text-gray-500">Total Quantity Sold</div>
              <div class="text-lg font-semibold" id="totalQty">-</div>
            </div>
          </div>
        </div>

        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <div class="flex items-center gap-2 mb-2">
            <i class="ph ph-star text-2xl text-yellow-500"></i>
            <h2 class="text-lg font-semibold">Best-Selling Products</h2>
          </div>
          <ul class="text-sm text-gray-600 space-y-2" id="bestseller-list">
            <?php include 'load_bestsellers.php'; ?>
          </ul>
          <button id="toggleBestsellersBtn" onclick="toggleBestsellers()" class="text-blue-500 text-sm mt-2">View All</button>
        </div>
      </div>


      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <div class="flex items-center gap-2 mb-2">
            <i class="ph ph-percent text-2xl text-cyan-500"></i>
            <h2 class="text-lg font-semibold">Category Contribution</h2>
          </div>
          <ul class="text-sm text-gray-600 space-y-1" id="category-contribution">
            <?php include 'fetch_category_contribution.php'; ?>
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <div class="flex items-center gap-2 mb-2">
            <i class="ph ph-package text-2xl text-pink-500"></i>
            <h2 class="text-lg font-semibold">Total Orders</h2>
          </div>
          <div class="text-2xl font-semibold" id="totalOrders">0</div>
        </div>

        <div class="bg-white p-4 rounded shadow transition duration-200 hover:shadow-lg">
          <div class="flex justify-between items-center mb-2">
            <div class="flex items-center gap-2">
              <i class="ph ph-warning text-2xl text-red-500"></i>
              <span class="text-lg font-semibold">Low in Stock</span>
            </div>
          </div>
          <div id="low-stock-widget">
            <ul class="mt-2 space-y-2 text-sm text-gray-600" id="low-stock-list">
              <?php
              $query = "
                SELECT p.name, p.image_1, SUM(pv.stock_quantity) AS total_quantity
                FROM product_variant pv
                JOIN product p ON pv.product_id = p.product_id
                GROUP BY p.product_id
                HAVING total_quantity < 6
                ORDER BY total_quantity ASC
                LIMIT 3
              ";
              $result = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<li class="flex items-center gap-3 mb-2">';
                echo '<img src="pics/' . htmlspecialchars($row['image_1']) . '" class="w-10 h-10 object-cover rounded" alt="product">';
                echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                echo '<span class="ml-auto text-red-600 font-medium">Qty: ' . $row['total_quantity'] . '</span>';
                echo '</li>';
              }
              ?>
            </ul>
            <button id="toggleLowStockBtn" onclick="toggleLowStock()" class="text-blue-500 text-sm mt-2">View All</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>

    window.addEventListener('DOMContentLoaded', () => {
    filterSales();
  });

    let showingAll = false;
    function toggleLowStock() {
      const btn = document.getElementById('toggleLowStockBtn');
      const list = document.getElementById('low-stock-list');
      if (!showingAll) {
        fetch('load_low_stock.php')
          .then(res => res.text())
          .then(data => {
            list.innerHTML = data;
            btn.innerText = "View Less";
            showingAll = true;
          });
      } else {
        fetch('load_low_stock.php?limit=3')
          .then(res => res.text())
          .then(data => {
            list.innerHTML = data;
            btn.innerText = "View All";
            showingAll = false;
          });
      }
    }

    let showingAllBest = false;
    function toggleBestsellers() {
      const btn = document.getElementById('toggleBestsellersBtn');
      const list = document.getElementById('bestseller-list');
      const from = document.getElementById('fromDate')?.value || '';
      const to = document.getElementById('toDate')?.value || '';
      const limit = showingAllBest ? '' : 'all';
      const params = new URLSearchParams();
      if (from) params.append('from', from);
      if (to) params.append('to', to);
      if (limit) params.append('limit', limit);
      fetch('load_bestsellers.php?' + params.toString())
        .then(res => res.text())
        .then(data => {
          list.innerHTML = data;
          btn.innerText = showingAllBest ? 'View All' : 'View Less';
          showingAllBest = !showingAllBest;
        });
    }

    function filterSales() {
      const from = document.getElementById('fromDate').value;
      const to = document.getElementById('toDate').value;
      const params = new URLSearchParams();
      if (from) params.append('from', from);
      if (to) params.append('to', to);
      fetch('fetch_total_sales.php?' + params.toString())
        .then(res => res.text())
        .then(data => {
          document.getElementById('totalSalesAmount').innerText = data;
        });
    }

    function filterBestsellers() {
      const from = document.getElementById('fromDate')?.value || '';
      const to = document.getElementById('toDate')?.value || '';
      const params = new URLSearchParams();
      if (from) params.append('from', from);
      if (to) params.append('to', to);
      fetch('load_bestsellers.php?' + params.toString())
        .then(res => res.text())
        .then(data => {
          document.getElementById('bestseller-list').innerHTML = data;
          document.getElementById('toggleBestsellersBtn').innerText = 'View All';
          showingAllBest = false;
        });
    }

    function filterOrders() {
      const from = document.getElementById('fromDate').value;
      const to = document.getElementById('toDate').value;
      const params = new URLSearchParams();
      if (from) params.append('from', from);
      if (to) params.append('to', to);
      fetch('fetch_total_orders.php?' + params.toString())
        .then(res => res.text())
        .then(data => {
          document.getElementById('totalOrders').innerText = data;
        });
    }

    function filterCategoryContribution() {
  const from = document.getElementById('fromDate')?.value || '';
  const to = document.getElementById('toDate')?.value || '';
  const params = new URLSearchParams();
  if (from) params.append('from', from);
  if (to) params.append('to', to);

  fetch('fetch_category_contribution.php?' + params.toString())
    .then(res => res.text())
    .then(data => {
      document.getElementById('category-contribution').innerHTML = data;
    });
}

function filterUsers() {
  const from = document.getElementById('fromDate').value;
  const to = document.getElementById('toDate').value;
  const params = new URLSearchParams();
  if (from) params.append('from', from);
  if (to) params.append('to', to);
  fetch('fetch_total_users.php?' + params.toString())
    .then(res => res.text())
    .then(data => {
      document.getElementById('totalUsers').innerText = data;
    });
}

function filterKPIs() {
  const from = document.getElementById('fromDate')?.value || '';
  const to = document.getElementById('toDate')?.value || '';
  const params = new URLSearchParams();
  if (from) params.append('from', from);
  if (to) params.append('to', to);

  fetch('fetch_kpis.php?' + params.toString())
    .then(res => res.json())
    .then(data => {
      document.getElementById('avgBasket').innerText = data.avg_basket || '-';
      document.getElementById('avgPrice').innerText = data.avg_price || '-';
      document.getElementById('upt').innerText = data.upt || '-';
      document.getElementById('totalQty').innerText = data.total_qty || '-';
    })
    .catch(err => {
      console.error('Error loading KPIs:', err);
    });
}


window.addEventListener('DOMContentLoaded', () => {
  filterSales();
  filterOrders();
  filterUsers();
  filterBestsellers();
  filterCategoryContribution();
  filterTotalViews();
  filterKPIs();
});


  </script>

</body>
</html>
