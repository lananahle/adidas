<?php
session_start();
require_once 'db_connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid order ID');
}

$order_id = (int)$_GET['id'];
$order = [];
$order_items = [];

$order_stmt = mysqli_prepare($conn, "
    SELECT o.*, u.name AS customer_name, u.email 
    FROM `order` o
    JOIN user u ON o.user_id = u.user_id
    WHERE o.order_id = ?
");
mysqli_stmt_bind_param($order_stmt, 'i', $order_id);
mysqli_stmt_execute($order_stmt);
$result = mysqli_stmt_get_result($order_stmt);
$order = mysqli_fetch_assoc($result);
mysqli_stmt_close($order_stmt);

$item_stmt = mysqli_prepare($conn, "
    SELECT p.name, p.image_1, od.quantity, od.unit_price, pv.size
    FROM order_detail od
    JOIN product_variant pv ON od.variant_id = pv.variant_id
    JOIN product p ON pv.product_id = p.product_id
    WHERE od.order_id = ?
");
mysqli_stmt_bind_param($item_stmt, 'i', $order_id);
mysqli_stmt_execute($item_stmt);
$item_result = mysqli_stmt_get_result($item_stmt);
$order_items = mysqli_fetch_all($item_result, MYSQLI_ASSOC);
mysqli_stmt_close($item_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order #<?= $order_id ?> - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<header class="flex items-center justify-center bg-white p-4 shadow-md fixed top-0 z-40 w-full min-h-[64px]">
  <div class="flex items-center gap-2">
    <img src="pics/logo.jpg" alt="Logo" class="h-8 w-auto">
    <h1 class="text-xl font-bold">adidas</h1>
  </div>
</header>

<nav class="bg-black text-white px-4 py-3 flex justify-between items-center fixed top-[64px] w-full z-30">
  <button onclick="toggleSidebar()" class="sm:hidden">
    <i class="ph ph-list text-2xl"></i>
  </button>
  <div class="text-sm font-medium">Admin Navigation</div>
</nav>

<div class="flex pt-[128px]">
  <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[104px] pt-6 transform transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0">
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

  <main class="flex-1 p-6 w-full ml-0 sm:ml-64">
    <a href="view_orders.php" class="text-sm text-black underline mb-4 inline-block">← Back to Orders</a>

    <h2 class="text-2xl font-semibold mb-4">Order #<?= $order_id ?></h2>

    <div class="bg-white p-6 rounded shadow mb-6 text-sm space-y-3 border border-gray-200">
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Customer Name:</span>
    <span class="font-semibold text-gray-800"><?= htmlspecialchars($order['customer_name']) ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Email:</span>
    <span class="text-gray-700"><?= htmlspecialchars($order['email']) ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Phone:</span>
    <span class="text-gray-700"><?= htmlspecialchars($order['phone_number']) ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Address:</span>
    <span class="text-gray-700 text-right"><?= htmlspecialchars($order['shipping_address']) ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Order Date:</span>
    <span class="text-gray-700"><?= $order['order_date'] ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Status:</span>
    <span class="font-semibold capitalize text-blue-600"><?= $order['order_status'] ?></span>
  </div>
  <div class="flex justify-between">
    <span class="text-gray-500 font-medium">Total Price:</span>
    <span class="text-green-700 font-bold">$<?= number_format($order['total_price'], 2) ?></span>
  </div>
</div>

    <?php if ($order['order_status'] != 'Rejected' && $order['order_status'] != 'Delivered'): ?>
    <form action="update_order_status.php" method="POST" onsubmit="return confirm('Are you sure you want to update the status?')" class="mb-6">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <label for="status" class="block mb-2 font-medium">Change Status</label>

        <?php
        $current_raw = $order['order_status'] ?? '';
        $current = strtolower(str_replace(' ', '_', $current_raw));
        $transitions = [
            'pending' => ['confirmed', 'rejected'],
            'confirmed' => ['in_progress'],
            'in_progress' => ['shipping'],
            'shipping' => ['delivered']
        ];
        $options = $transitions[$current] ?? [];
        ?>

        <select name="new_status" id="status" class="border p-2 rounded mr-2" required>
        <?php foreach ($options as $option): ?>
            <option value="<?= $option ?>"><?= ucwords(str_replace('_', ' ', $option)) ?></option>
        <?php endforeach; ?>
        </select>

        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Update</button>

        <?php if (empty($options)): ?>
        <p class="text-red-600 font-semibold mt-2">No valid status transitions for this order.</p>
        <?php endif; ?>
    </form>
    <?php endif; ?>

    <h3 class="text-lg font-semibold mb-2">Products</h3>
    <div class="space-y-4">
      <?php foreach ($order_items as $item): ?>
        <div class="flex gap-4 bg-white p-4 rounded shadow text-sm items-center">
          <img src="pics/<?= htmlspecialchars($item['image_1']) ?>" class="w-16 h-16 object-cover rounded" alt="product">
          <div>
            <p><strong>Product:</strong> <?= htmlspecialchars($item['name']) ?></p>
            <p><strong>Size:</strong> <?= htmlspecialchars($item['size']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($item['unit_price'], 2) ?></p>
            <p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
            <p><strong>Subtotal:</strong> $<?= number_format($item['unit_price'] * $item['quantity'], 2) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
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
