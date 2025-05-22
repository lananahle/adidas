<?php
include 'db_connection.php';

$term = $_GET['term'] ?? '';

if ($term !== '') {
    $stmt = mysqli_prepare($conn, "
        SELECT product_id, name, image_1
        FROM product
        WHERE name LIKE CONCAT('%', ?, '%') AND is_deleted = 0
        LIMIT 5
    ");
    mysqli_stmt_bind_param($stmt, "s", $term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row;
    }

    echo json_encode($suggestions);
}
?>
