<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = intval($_POST['product_id']);
  $category_id = intval($_POST['category_id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $price = floatval($_POST['price']);
  $on_promotion = isset($_POST['on_promotion']) ? 1 : 0;
  $promotion_price = $on_promotion ? floatval($_POST['promotion_price']) : 'NULL';
  $is_deleted = isset($_POST['is_deleted']) ? 1 : 0;

  $image_update_sql = '';
  if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['product_image'];
    $imageName = time() . '_' . basename($image['name']);
    $uploadDir = 'pics/';
    $uploadPath = $uploadDir . $imageName;

    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
      die('Invalid file type. Only JPG, PNG, and WEBP are allowed.');
    }

    if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
      $image_update_sql = ", image_1 = '$imageName'";
    }
  }

  $updateQuery = "
    UPDATE product
    SET name = '$name',
        description = '$description',
        price = $price,
        category_id = $category_id,
        is_on_promotion = $on_promotion,
        promotion_price = $promotion_price,
        is_deleted = $is_deleted
        $image_update_sql
    WHERE product_id = $product_id
  ";

  if (!mysqli_query($conn, $updateQuery)) {
    die('Product update failed: ' . mysqli_error($conn));
  }

  $sizes = $_POST['sizes'];
  $quantities = $_POST['quantities'];

  foreach ($sizes as $i => $size) {
    $size = mysqli_real_escape_string($conn, trim($size));
    $qty = intval($quantities[$i]);

    if ($size === '' || $qty <= 0) continue;

    $checkQuery = "SELECT * FROM product_variant WHERE product_id = $product_id AND size = '$size'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      $updateQty = "
        UPDATE product_variant
        SET stock_quantity = stock_quantity + $qty
        WHERE product_id = $product_id AND size = '$size'
      ";
      mysqli_query($conn, $updateQty);
    } else {
      $insertVariant = "
        INSERT INTO product_variant (product_id, size, stock_quantity)
        VALUES ($product_id, '$size', $qty)
      ";
      mysqli_query($conn, $insertVariant);
    }
  }

  header("Location: update_product.php?success=1");
  exit;
} else {
  die('Invalid request method.');
}
?>
