<?php
session_start();
require_once 'db_connection.php';

$statuses = ['pending', 'confirmed', 'In Progress', 'shipping', 'delivered', 'rejected'];
$status_counts = array_fill_keys($statuses, 0);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;
$orders = [];
$total_pages = 1;

$conn_error = false;

foreach ($statuses as $status) {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM `order` WHERE order_status = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        $status_counts[$status] = $count;
    }
}

$where = "WHERE 1=1";
$params = [];
$types = '';

if ($search !== '') {
    $where .= " AND order_id = ?";
    $params[] = $search;
    $types .= 'i';
}

if ($status_filter !== '') {
    $where .= " AND order_status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

$count_params = $params;
$count_types = $types;

$where .= " ORDER BY order_date DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $per_page;
$types .= 'ii';

$count_query = "SELECT COUNT(*) FROM `order` " . str_replace(" ORDER BY order_date DESC LIMIT ?, ?", "", $where);
$count_stmt = mysqli_prepare($conn, $count_query);
if ($count_stmt) {
    if (!empty($count_params)) {
        mysqli_stmt_bind_param($count_stmt, $count_types, ...$count_params);
    }
    mysqli_stmt_execute($count_stmt);
    mysqli_stmt_bind_result($count_stmt, $total_orders);
    mysqli_stmt_fetch($count_stmt);
    mysqli_stmt_close($count_stmt);
    $total_pages = max(1, ceil($total_orders / $per_page));
}

$order_query = "SELECT * FROM `order` $where";
$stmt = mysqli_prepare($conn, $order_query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - View Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>

  <style>
  .main-content {
    padding-top: 10px;
  }

  @media (max-width: 640px) {
    .main-content {
      padding-top: 100px;
    }
  }
</style>


</head>
<body class="bg-gray-100 min-h-screen">

  <header class="flex items-center justify-center bg-white p-4 shadow-md fixed top-0 z-40 w-full min-h-[64px]">
    <div class="flex items-center gap-2">
      <img src="pics/logo.jpg" alt="Logo" class="h-8 w-auto">
      <h1 class="text-xl font-bold">adidas</h1>
    </div>
  </header>

<nav class="bg-black text-white px-4 py-3 fixed top-[64px] w-full z-30 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
  <div class="flex justify-between items-center w-full">
    <button onclick="toggleSidebar()" class="sm:hidden">
  <i class="ph ph-list text-2xl"></i>
</button>
    <div class="text-sm font-medium">Admin Navigation</div>
  </div>

  <form method="GET" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto mt-2 sm:mt-0 pr-4">
     <input type="text" name="search" placeholder="Search Order #"
           value="<?= htmlspecialchars($search) ?>"
           class="text-black px-2 py-1 rounded w-full sm:w-64" />
    <button type="submit" class="bg-white text-black px-3 rounded w-fit">Search</button>
  </form>
</nav>

  <div class="flex pt-[142px]">
    <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[104px] pt-6 transform transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0 sm:block z-40">
       <nav class="px-4 space-y-4">
        <ul class="space-y-2">
          <li><a href="admin_dashboard.php" class="block p-2 hover:bg-gray-800 rounded">Dashboard</a></li>
          <li><a href="add_product.php" class="block p-2 hover:bg-gray-800 rounded">Add Product</a></li>
          <li><a href="update_product.php" class="block p-2 hover:bg-gray-800 rounded">Update Product</a></li>
          <li><a href="view_orders.php" class="block p-2 bg-white text-black rounded">View Orders</a></li>
          <li><a href="add_admin.php" class="block p-2 hover:bg-gray-800 rounded">Add Admin</a></li>
          <li><a href="admin_logout.php" class="block p-2 hover:bg-gray-800 rounded">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content flex-1 px-6 pb-6 w-full ml-0 sm:ml-64">
      <h2 class="text-2xl font-semibold mb-4">All Orders</h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <?php foreach ($status_counts as $status => $count): ?>
          <div class="bg-white p-4 shadow-md rounded text-center border border-gray-200 hover:shadow-lg transition">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1"><?= $status ?></div>
            <div class="text-2xl font-bold text-gray-800"><?= $count ?></div>
          </div>
        <?php endforeach; ?>
      </div>

      <form method="GET" class="mb-4 flex items-center gap-2">
        <label for="status" class="text-sm font-medium">Filter by Status:</label>
        <select name="status" id="status" class="border p-2 rounded">
          <option value="">All</option>
          <?php foreach ($statuses as $s): ?>
            <option value="<?= $s ?>" <?= $s == $status_filter ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-black text-white px-3 py-1 rounded">Apply</button>
      </form>

      <div class="space-y-4">
        <?php foreach ($orders as $order): ?>
          <div class="bg-white p-4 rounded shadow text-sm space-y-2">
            <div class="flex justify-between items-center">
              <h3 class="text-lg font-bold">Order #<?= $order['order_id'] ?></h3>
              <a href="admin_order_details.php?id=<?= $order['order_id'] ?>" class="bg-black text-white px-3 py-1 rounded text-sm">View Details</a>
            </div>
            <div><strong>Date:</strong> <?= $order['order_date'] ?></div>
            <div><strong>Status:</strong> <span class="capitalize font-medium text-blue-700"><?= $order['order_status'] ?></span></div>
            <div><strong>Phone:</strong> <?= htmlspecialchars($order['phone_number']) ?></div>
            <div><strong>Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></div>
            <div><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></div>
            <div><strong>Total Quantity:</strong>
              <?php
                $qty_stmt = mysqli_prepare($conn, "SELECT SUM(quantity) FROM order_detail WHERE order_id = ?");
                mysqli_stmt_bind_param($qty_stmt, 'i', $order['order_id']);
                mysqli_stmt_execute($qty_stmt);
                mysqli_stmt_bind_result($qty_stmt, $total_qty);
                mysqli_stmt_fetch($qty_stmt);
                mysqli_stmt_close($qty_stmt);
                echo $total_qty ?? 0;
              ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($total_pages > 1): ?>
        <div class="mt-6 flex justify-center gap-2">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&status=<?= urlencode($status_filter) ?>&search=<?= urlencode($search) ?>"
               class="px-3 py-1 border rounded <?= $i == $page ? 'bg-black text-white' : 'bg-white text-black' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    </main>
  </div>

  <script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
  }
</script>

</body>
</html>
