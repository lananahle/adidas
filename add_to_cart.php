<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id    = $_SESSION['user_id'];
$product_id = intval($_POST['product_id'] ?? 0);
$variant_id = intval($_POST['variant_id'] ?? 0);
$quantity   = max(1, intval($_POST['quantity'] ?? 1));
$return     = $_POST['return'] ?? 'index';
$page       = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;

if (!$product_id || !$variant_id) {
    die('Invalid product/size selection.');
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT quantity FROM cart WHERE user_id = ? AND variant_id = ?"
);
mysqli_stmt_bind_param($stmt, 'ii', $user_id, $variant_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_bind_result($stmt, $existing_qty);
    mysqli_stmt_fetch($stmt);
    $new_qty = $existing_qty + $quantity;
    mysqli_stmt_close($stmt);

    $upd = mysqli_prepare(
        $conn,
        "UPDATE cart SET quantity = ? WHERE user_id = ? AND variant_id = ?"
    );
    mysqli_stmt_bind_param($upd, 'iii', $new_qty, $user_id, $variant_id);
    mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);
} else {
    mysqli_stmt_close($stmt);
    $ins = mysqli_prepare(
        $conn,
        "INSERT INTO cart (user_id, variant_id, quantity) VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($ins, 'iii', $user_id, $variant_id, $quantity);
    mysqli_stmt_execute($ins);
    mysqli_stmt_close($ins);
}

$params = http_build_query([
    'id'     => $product_id,
    'return' => $return,
    'page'   => $page,
    'added'  => 'cart'
]);
header("Location: product.php?{$params}");
exit;
