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



// addtocart 

// Kiểm tra nếu có dữ liệu POST gửi đến
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];

    // Lấy thông tin sản phẩm từ bảng products
    $sql = "SELECT nameProducts, Price FROM cart WHERE ID = '$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row['nameProducts'];
        $productPrice = $row['Price'];
        $quantity = 1; // Số lượng mặc định khi thêm vào giỏ hàng

        // Kiểm tra sản phẩm đã có trong giỏ hàng hay chưa
        $sql = "SELECT * FROM ordercart WHERE ID = '$productId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $sql = "UPDATE ordercart SET Quantity = Quantity + 1 WHERE ID = '$productId'";
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $sql = "INSERT INTO ordercart (nameProducts, ID, Price, Quantity) VALUES ('$productName', '$productId', '$productPrice', '$quantity')";
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

// Xác định số sản phẩm mỗi trang và trang hiện tại
$items_per_page = 7;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Truy vấn tổng số sản phẩm
$total_sql = "SELECT COUNT(*) as total FROM ordercart";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

$totalPriceQuery = "SELECT SUM(Price * Quantity) AS total FROM ordercart";
$totalPriceResult = $conn->query($totalPriceQuery);
$totalPriceRow = $totalPriceResult->fetch_assoc();
$totalPrice = $totalPriceRow['total'];

$sql1 = "SELECT ID, nameProducts, Price, Quantity FROM cart LIMIT $offset, $items_per_page";
$result1 = $conn->query($sql);



$conn->close();
?>