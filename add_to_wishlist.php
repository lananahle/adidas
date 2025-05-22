<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id    = $_SESSION['user_id'];
$product_id = intval($_POST['product_id'] ?? 0);
$return     = $_POST['return'] ?? 'index';
$page       = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;

if (!$product_id) {
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT 1 FROM wishlist WHERE user_id = ? AND product_id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, 'ii', $user_id, $product_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    $params = http_build_query([
        'id'     => $product_id,
        'return' => $return,
        'page'   => $page,
        'added'  => 'exists_wishlist'
    ]);
    header("Location: product.php?{$params}");
    exit;
}
mysqli_stmt_close($stmt);

$ins = mysqli_prepare(
    $conn,
    "INSERT INTO wishlist (user_id, product_id, created_at) VALUES (?, ?, NOW())"
);
mysqli_stmt_bind_param($ins, 'ii', $user_id, $product_id);
mysqli_stmt_execute($ins);
mysqli_stmt_close($ins);

$params = http_build_query([
    'id'     => $product_id,
    'return' => $return,
    'page'   => $page,
    'added'  => 'wishlist'
]);
header("Location: product.php?{$params}");
exit;
