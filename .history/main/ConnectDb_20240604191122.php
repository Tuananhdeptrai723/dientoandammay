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


function addToCart($conn, $productId, $userId) {
    $sql = "INSERT INTO cartorder (ProductID, UserID) VALUES ($productId, $userId)";

    if ($conn->query($sql) === TRUE) {
        // Sản phẩm đã được thêm vào giỏ hàng thành công
        return true;
    } else {
        // Lỗi khi thêm sản phẩm vào giỏ hàng
        return false;
    }
}

// Xử lý yêu cầu AJAX từ JavaScript
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $userId = 1; // Thay đổi giá trị này bằng ID người dùng thực tế

    if (addToCart($conn, $productId, $userId)) {
        $product = getProductById($conn, $productId);
        $response = array(
            'success' => true,
            'productName' => $product['nameProducts'],
            'productPrice' => $product['Price']
        );
    } else {
        $response = array('success' => false);
    }

    echo json_encode($response);
}

// Hàm lấy thông tin sản phẩm dựa trên ID
function getProductById($conn, $productId) {
    $sql = "SELECT * FROM products WHERE ID = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

$conn->close();
?>