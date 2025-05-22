<?php
require_once 'db_connection.php';

$limit = 12;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? "WHERE name LIKE '%$search%' OR product_id LIKE '%$search%'" : '';

$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM product $where");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalPages = ceil($totalRow['total'] / $limit);

$productQuery = "SELECT product_id, name, image_1 FROM product $where ORDER BY product_id DESC LIMIT $start, $limit";
$productResult = mysqli_query($conn, $productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Product - Admin Panel</title>
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
  </nav>

  <div class="flex pt-[112px]">
    <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[104px] pt-6 transform transition-transform duration-200 ease-in-out z-40 shadow-md -translate-x-full sm:translate-x-0">
      <nav class="px-4 space-y-4">
        <ul class="space-y-2">
          <li><a href="admin_dashboard.php" class="block p-2 hover:bg-gray-800 rounded">Dashboard</a></li>
          <li><a href="add_product.php" class="block p-2 hover:bg-gray-800 rounded">Add Product</a></li>
          <li><a href="update_product.php" class="block p-2 bg-white text-black rounded">Update Product</a></li>
          <li><a href="view_orders.php" class="block p-2 hover:bg-gray-800 rounded">View Orders</a></li>
          <li><a href="add_admin.php" class="block p-2 hover:bg-gray-800 rounded">Add Admin</a></li>
          <li><a href="admin_logout.php" class="block p-2 hover:bg-gray-800 rounded">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main class="flex-1 p-6 w-full transition-all duration-300 ease-in-out ml-0 sm:ml-64">
      <h2 class="text-2xl font-semibold mb-6">Update Product</h2>

      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded border border-green-300">
            Product updated successfully!
        </div>
    <?php endif; ?>

      <form method="GET" class="mb-4 max-w-md">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or ID..." class="w-full border p-2 rounded">
    </form>

      <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php while ($row = mysqli_fetch_assoc($productResult)) : ?>
            <a href="edit_product.php?id=<?= $row['product_id'] ?>" class="bg-white rounded shadow hover:shadow-lg p-4 text-center transition">
                <img src="pics/<?= htmlspecialchars($row['image_1']) ?>" alt="Product Image" class="w-full h-40 object-cover rounded mb-2">
                <h3 class="text-sm font-medium"><?= htmlspecialchars($row['name']) ?></h3>
            </a>
        <?php endwhile; ?>
      </div>

      <div class="flex justify-center mt-6 space-x-1">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 border rounded <?= $i == $page ? 'bg-black text-white' : 'bg-white' ?>">
            <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    </main>
  </div>

  <script>
    function filterProducts() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const cards = document.querySelectorAll('#productGrid a');

      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? 'block' : 'none';
      });
    }
  </script>
</body>
</html>
