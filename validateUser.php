<?php
session_start();
ob_start();

// Kết nối đến CSDL
include './Config.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra dữ liệu đầu vào
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Xử lí thông tin đăng nhập với prepared statement để tránh SQL Injection
    $stmt = $conn->prepare("SELECT * FROM account WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($password == $row['Pass']) {
            // Đăng nhập thành công, lưu trạng thái vào Session
            $_SESSION["Login"] = true;
            $_SESSION["Username"] = $username; // Lưu thông tin người dùng vào session nếu cần
            
            $user_id = $row['ID']; // Lấy ID người dùng từ kết quả truy vấn
            $_SESSION['user_id'] = $user_id; // Lưu ID vào session
    
            echo "<script>alert('Đăng nhập thành công'); window.location='./main/main.php';</script>"; // Chuyển hướng đến trang dashboard sau khi đăng nhập thành công
           
        } else {
            // Mật khẩu không đúng
            echo "<script>alert('Sai mật khẩu'); window.location='./index.html?error=invalid_credentials';</script>";
        }
    } else {
        // Tài khoản không tồn tại
        echo "<script>alert('Tài khoản không tồn tại'); window.location='./index.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>