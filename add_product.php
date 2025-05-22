<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product - Admin Panel</title>
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
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[104px] pt-6 transform transition-transform duration-200 ease-in-out z-40 shadow-md -translate-x-full sm:translate-x-0">
      <nav class="px-4 space-y-4">
        <ul class="space-y-2">
          <li><a href="admin_dashboard.php" class="block p-2 hover:bg-gray-800 rounded">Dashboard</a></li>
          <li><a href="add_product.php" class="block p-2 bg-white text-black rounded">Add Product</a></li>
          <li><a href="update_product.php" class="block p-2 hover:bg-gray-800 rounded">Update Product</a></li>
          <li><a href="view_orders.php" class="block p-2 hover:bg-gray-800 rounded">View Orders</a></li>
          <li><a href="add_admin.php" class="block p-2 hover:bg-gray-800 rounded">Add Admin</a></li>
          <li><a href="admin_logout.php" class="block p-2 hover:bg-gray-800 rounded">Logout</a></li>        
        </ul>
      </nav>
    </aside>

    <main class="flex-1 p-6 w-full transition-all duration-300 ease-in-out ml-0 sm:ml-64">
      <h2 class="text-2xl font-semibold mb-6">Add Product</h2>
      <form action="submit_product.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md space-y-4">
        <input name="name" type="text" placeholder="Product Name" class="w-full border p-2 rounded" required>
        <textarea name="description" placeholder="Product Description" class="w-full border p-2 rounded"></textarea>
        <input name="price" type="number" placeholder="Price" class="w-full border p-2 rounded" required>
        <input name="product_image" type="file" accept="image/*" class="w-full border p-2 rounded" required>

        <select name="category" class="w-full border p-2 rounded">
            <option value="1">Footwear</option>
            <option value="2">Clothing</option>
            <option value="3">Slides</option>
            <option value="4">Accessories</option>
        </select>

        <div id="variant-section" class="space-y-2">
          <div class="flex gap-2 flex-wrap">
            <input name="sizes[]" type="text" placeholder="Size (e.g., M)" class="border p-2 rounded w-full sm:w-1/2">
            <input name="quantities[]" type="number" placeholder="Quantity" class="flex-1 border p-2 rounded">
          </div>
        </div>
        <button type="button" onclick="addVariant()" class="text-blue-600">+ Add More Sizes</button>

        <div class="flex justify-end">
          <button type="submit" class="bg-black text-white px-4 py-2 rounded">Add Product</button>
        </div>
      </form>
    </main>
  </div>

  <script>
    function addVariant() {
      const variantDiv = document.createElement('div');
      variantDiv.className = "flex gap-2 flex-wrap mt-2";
      variantDiv.innerHTML = `
        <input name="sizes[]" type="text" placeholder="Size (e.g., M)" class="border p-2 rounded w-full sm:w-1/2">
        <input name="quantities[]" type="number" placeholder="Quantity" class="flex-1 border p-2 rounded">
      `;
      document.getElementById('variant-section').appendChild(variantDiv);
    }

    function validateForm(event) {
  const sizes = document.getElementsByName('sizes[]');
  const quantities = document.getElementsByName('quantities[]');
  let valid = true;

  for (let i = 0; i < sizes.length; i++) {
    const size = sizes[i].value.trim();
    const qty = quantities[i].value.trim();

    if (!size && !qty) continue;

    if ((size && !qty) || (!size && qty)) {
      alert(`Please fill both size and quantity for entry #${i + 1} or leave both empty.`);
      valid = false;
      break;
    }
  }

  if (!valid) {
    event.preventDefault();
  }
}

  document.querySelector("form").addEventListener("submit", validateForm);

  </script>
</body>
</html>
