<?php
include 'db_connection.php';
session_start();

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $errors[] = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  } elseif ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
  } elseif (strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password)) {
    $errors[] = "Password must be at least 8 characters and include uppercase, lowercase, and a number.";
  } else {
    $check = mysqli_prepare($conn, "SELECT user_id FROM user WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
      $errors[] = "Email is already registered.";
    } else {
      $date_joined = date('Y-m-d');
      $role = 'admin';

      $insert = mysqli_prepare($conn, "INSERT INTO user (name, email, password, date_joined, role) VALUES (?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($insert, "sssss", $name, $email, $password, $date_joined, $role);

      if (mysqli_stmt_execute($insert)) {
        $success = "Admin added successfully.";
      } else {
        $errors[] = "Error inserting admin: " . mysqli_error($conn);
      }

      mysqli_stmt_close($insert);
    }

    mysqli_stmt_close($check);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <style>
    .main-content { padding-top: 20px; }
    @media (max-width: 640px) { .main-content { padding-top: 100px; } }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">
  <header class="flex items-center justify-center bg-white p-4 shadow-md fixed top-0 z-40 w-full min-h-[64px]">
    <div class="flex items-center gap-2">
      <img src="pics/logo.jpg" alt="Logo" class="h-8 w-auto">
      <h1 class="text-xl font-bold">adidas</h1>
    </div>
  </header>

  <nav class="bg-black text-white px-4 py-3 fixed top-[64px] w-full z-30 flex justify-between items-center">
    <button onclick="toggleSidebar()" class="sm:hidden"><i class="ph ph-list text-2xl"></i></button>
    <div class="text-sm font-medium">Admin Navigation</div>
  </nav>

  <div class="flex pt-[112px]">
    <aside id="sidebar" class="bg-black text-white w-64 min-h-screen fixed top-[104px] pt-6 transform transition-transform duration-200 ease-in-out z-40 shadow-md -translate-x-full sm:translate-x-0">
      <nav class="px-4 space-y-4">
        <ul class="space-y-2">
          <li><a href="admin_dashboard.php" class="block p-2 hover:bg-gray-800 rounded">Dashboard</a></li>
          <li><a href="add_product.php" class="block p-2 hover:bg-gray-800 rounded">Add Product</a></li>
          <li><a href="update_product.php" class="block p-2 hover:bg-gray-800 rounded">Update Product</a></li>
          <li><a href="view_orders.php" class="block p-2 hover:bg-gray-800 rounded">View Orders</a></li>
          <li><a href="add_admin.php" class="block p-2 bg-white text-black rounded">Add Admin</a></li>
          <li><a href="admin_logout.php" class="block p-2 hover:bg-gray-800 rounded">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content flex-1 p-6 w-full ml-0 sm:ml-64">
      <h2 class="text-2xl font-semibold mb-6">Add New Admin</h2>

      <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 border border-red-400 p-3 rounded mb-4">
          <ul class="text-sm list-disc list-inside">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php elseif (!empty($success)): ?>
        <div class="bg-green-100 text-green-700 border border-green-400 p-3 rounded mb-4 text-sm">
          <?= $success ?>
        </div>
      <?php endif; ?>

      <form action="add_admin.php" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium mb-1">Name</label>
          <input type="text" name="name" id="name" required class="w-full border p-2 rounded" />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="email" id="email" required class="w-full border p-2 rounded" />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium mb-1">Password</label>
          <div class="relative">
            <input type="password" name="password" id="password" required class="w-full border p-2 rounded pr-10" />
            <i class="ph ph-eye absolute right-3 top-2.5 text-xl cursor-pointer" onclick="toggleVisibility('password', this)"></i>
          </div>
        </div>
        <div>
          <label for="confirm_password" class="block text-sm font-medium mb-1">Confirm Password</label>
          <div class="relative">
            <input type="password" name="confirm_password" id="confirm_password" required class="w-full border p-2 rounded pr-10" />
            <i class="ph ph-eye absolute right-3 top-2.5 text-xl cursor-pointer" onclick="toggleVisibility('confirm_password', this)"></i>
          </div>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-black text-white px-4 py-2 rounded">Add Admin</button>
        </div>
      </form>
    </main>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }

    function toggleVisibility(id, icon) {
      const input = document.getElementById(id);
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      icon.classList.toggle('ph-eye');
      icon.classList.toggle('ph-eye-slash');
    }
  </script>
</body>
</html>
