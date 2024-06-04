<?php
include 'ConnectDb.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đặt Đồ Ăn</title>
  <link rel="stylesheet" href="./main.css">
  <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    
</head>
<body>
  <div class="container">
    <h1>Đặt Đồ Ăn</h1>
    <div class="menu">
      <div class="product-container">
          <?php foreach ($products as $product): ?>
            <div class="menu-item">
              <img src="../asset/image/food<?php echo $product['ID']; ?>.jpg">
              <h3><?php echo $product['nameProducts']; ?></h3>
              <p>Số lượng: <?php echo $product['Quantity']; ?></p>
              <span class="price">$<?php echo $product['Price']; ?></span>
              <button <?php echo "onclick='addToCartClicked(" . $product["ID"] . ")'"?>  class="add-to-cart">Thêm vào giỏ hàng</button>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    <div class="pagination">
      <button class="prev-page">Trước</button>
      <span class="current-page">1</span>
      <button class="next-page">Sau</button>
    </div>
    <div class="cart">
      <h2>Giỏ Hàng</h2>
      <ul class="cart-items"></ul>
      <p class="total">Tổng: $0</p>
      <button class="checkout">Thanh Toán</button>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./main.js"></script>
</body>

<script>
 function addToCartClicked(productId) {
  $.ajax({
    url: "./ConnectDb.php",
    type: "POST",
    data: { productId: productId },
    success: function (response) {
      // Xử lý phản hồi từ PHP
      const { success, productName, productPrice } = JSON.parse(response);
      
      if (success) {
        // Thêm sản phẩm vào giỏ hàng trên giao diện
        updateCart(productId, productName, productPrice, 1);
        showCartNotification(); // Hiển thị thông báo thành công
      } else {
        console.log("Lỗi khi thêm sản phẩm vào giỏ hàng");
      }
    },
    error: function (xhr, status, error) {
      console.log("Lỗi AJAX:", error);
    },
  });
}
</script>
</html>