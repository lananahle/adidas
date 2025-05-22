<?php
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
  die('Product ID not provided.');
}

$product_id = intval($_GET['id']);

$categories = [];
$catResult = mysqli_query($conn, "SELECT * FROM category");
while ($row = mysqli_fetch_assoc($catResult)) {
  $categories[] = $row;
}

$query = "SELECT * FROM product WHERE product_id = $product_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  die('Product not found.');
}

$product = mysqli_fetch_assoc($result);
$name = htmlspecialchars($product['name']);
$description = htmlspecialchars($product['description']);
$price = $product['price'];
$image_1 = htmlspecialchars($product['image_1']);
$on_promotion = $product['is_on_promotion'] ?? 0;
$promotion_price = $product['promotion_price'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Admin Panel</title>
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
      <a href="update_product.php" class="mb-4 inline-flex items-center text-sm font-medium text-black hover:text-blue-600 transition">
  <i class="ph ph-arrow-left mr-1"></i> Back to Update Page
</a>
      <h2 class="text-2xl font-semibold mb-6">Edit Product</h2>

      <form action="update_product_handler.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md space-y-4">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <input name="name" type="text" placeholder="Product Name" class="w-full border p-2 rounded" required value="<?= $name ?>">
        <textarea name="description" placeholder="Product Description" class="w-full border p-2 rounded"><?= $description ?></textarea>
        <input name="price" type="number" placeholder="Price" class="w-full border p-2 rounded" required value="<?= $price ?>">
        <input name="product_image" type="file" accept="image/*" class="w-full border p-2 rounded">

        <select name="category_id" class="w-full border p-2 rounded" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= $product['category_id'] == $cat['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="flex items-center gap-4">
          <label class="flex items-center gap-2">
            <input type="checkbox" name="on_promotion" id="promoCheckbox" onchange="togglePromoPrice()" <?= $on_promotion ? 'checked' : '' ?>>
            <span>On Promotion</span>
          </label>
          <input type="number" name="promotion_price" id="promoPriceInput" placeholder="Promotion Price" class="border p-2 rounded <?= $on_promotion ? '' : 'hidden' ?>" value="<?= $promotion_price ?>">
        </div>

        <div class="space-y-2">
          <label class="block font-medium">Add or Update Sizes</label>
          <div id="variant-section">
            <div class="flex flex-wrap gap-4">
                <input name="sizes[]" type="text" placeholder="Size (e.g., M or 40)" class="border p-2 rounded w-full sm:max-w-[48%]">
                <input name="quantities[]" type="number" placeholder="Quantity to Add" class="border p-2 rounded w-full sm:max-w-[48%]">
            </div>
          </div>
          <button type="button" onclick="addVariant()" class="text-blue-600">+ Add More Sizes</button>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_deleted" id="deleteToggle" <?= $product['is_deleted'] == 1 ? 'checked' : '' ?>>
            <label for="deleteToggle" class="text-red-700 font-medium">Remove from all public pages</label>
        </div>

        <div class="flex justify-end">
          <button type="submit" class="bg-black text-white px-4 py-2 rounded">Update Product</button>
        </div>
      </form>
    </main>
  </div>

  <script>
    function addVariant() {
      const variantDiv = document.createElement('div');
      variantDiv.className = "flex gap-2 mt-2 flex-wrap";
      variantDiv.innerHTML = `
  <input name=\"sizes[]\" type=\"text\" placeholder=\"Size\" class=\"border p-2 rounded w-full sm:max-w-[48%]\">
  <input name=\"quantities[]\" type=\"number\" placeholder=\"Quantity\" class=\"border p-2 rounded w-full sm:max-w-[48%]\">
`;
      document.getElementById('variant-section').appendChild(variantDiv);
    }

    function togglePromoPrice() {
      const checkbox = document.getElementById('promoCheckbox');
      const promoInput = document.getElementById('promoPriceInput');
      promoInput.classList.toggle('hidden', !checkbox.checked);
    }
  </script>
</body>
</html>
