<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?"
    );
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header('Location: wishlist.php');
exit;
?>
