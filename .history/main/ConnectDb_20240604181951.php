<?php
session_start();
ob_start();

// Kết nối đến CSDL
include './Config.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // Truy vấn dữ liệu từ bảng products với phân trang
    $sql = "SELECT ID, nameProducts, Price, Quantity  FROM cart";
    $result2 = $conn->query($sql);

$conn->close();
?>