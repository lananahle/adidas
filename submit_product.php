<?php
require_once 'db_connection.php';

$image = $_FILES['product_image'];
$imageName = time() . '_' . basename($image['name']);
$uploadDir = 'pics/';
$uploadPath = $uploadDir . $imageName;

$allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
$ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
if (!in_array($ext, $allowedTypes)) {
    die('Invalid file type. Only JPG, PNG, and WEBP are allowed.');
}

if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
    die('Image upload failed.');
}

$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = floatval($_POST['price']);
$category_id = intval($_POST['category']);

$category_id = intval($_POST['category']);

$insertProduct = "INSERT INTO product (name, description, price, image_1, category_id)
                  VALUES ('$name', '$description', $price, '$imageName', $category_id)";

if (!mysqli_query($conn, $insertProduct)) {
    echo "MySQL ERROR: " . mysqli_error($conn);
    exit;
}

$productId = mysqli_insert_id($conn);

$sizes = $_POST['sizes'];
$quantities = $_POST['quantities'];

foreach ($sizes as $i => $size) {
    $size = trim($size);
    $qty = trim($quantities[$i]);

    if ($size !== '' && $qty !== '') {
        $size = mysqli_real_escape_string($conn, $size);
        $qty = intval($qty);

        $insertVariant = "INSERT INTO product_variant (product_id, size, stock_quantity)
                          VALUES ($productId, '$size', $qty)";
        mysqli_query($conn, $insertVariant);
    }
}

header("Location: add_product.php?success=1");
exit;
?>
