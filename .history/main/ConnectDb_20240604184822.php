<?php
session_start();
ob_start();

// Kết nối đến CSDL
include '../config.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT * FROM cart LIMIT 15";
$result = $conn->query($sql);

// Tạo mảng chứa dữ liệu sản phẩm
$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}


// Kiểm tra nếu có dữ liệu POST gửi đến
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];

    // Lấy thông tin sản phẩm từ bảng products
    $sql = "SELECT TenSP, Price FROM products WHERE ID = '$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row['TenSP'];
        $productPrice = $row['Price'];
        $quantity = 1; // Số lượng mặc định khi thêm vào giỏ hàng

        // Kiểm tra sản phẩm đã có trong giỏ hàng hay chưa
        $sql = "SELECT * FROM cart WHERE ID = '$productId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $sql = "UPDATE cart SET Quantity = Quantity + 1 WHERE ID = '$productId'";
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $sql = "INSERT INTO cart (nameProducts, ID, Price, Quantity) VALUES ('$productName', '$productId', '$productPrice', '$quantity')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Add to cart success!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            
        }
    } else {
        echo "Product not found!";
    }
}

$conn->close();
?>