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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container">
    <h1>Đặt Đồ Ăn</h1>
    <div class="menu">
      <div class="product-container">
          <?php foreach ($products as $product): ?>
            <div class="menu-item">
              <img src="../asset/image/food<?php echo $product['ID']; ?>.jpg">
              <?php print_r( $product['ID'])?>
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
  <script src="./main.js"></script>
</body>

<script>
function addToCartClicked(productId) {
  $.ajax({
    url: "../main/addtocart.php",
    type: "POST",
    data: { productId: productId },
    success: function () {
      console.log("success");
      alert('Thêm vào giỏ hàng thành công')
    },
    error: function (xhr, status, error) {
      console.log("error");
      console.log("Product ID:", productId);
    },
  });
}
</script>
</html>