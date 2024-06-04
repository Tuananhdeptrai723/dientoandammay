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
              <button class="add-to-cart">Thêm vào giỏ hàng</button>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    <div class="cart">
      <h2>Giỏ Hàng</h2>
      <ul class="cart-items"></ul>
      <p class="total">Tổng: $0</p>
      <button class="checkout">Thanh Toán</button>
    </div>
  </div>
  <script src="./main.js"></script>
</body>
</html>