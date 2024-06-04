const productsPerPage = 3;
let currentPage = 1;
const menuItems = document.querySelectorAll(".menu-item");
const totalPages = Math.ceil(menuItems.length / productsPerPage);

function showPage(page) {
  const startIndex = (page - 1) * productsPerPage;
  const endIndex = startIndex + productsPerPage;

  menuItems.forEach((item, index) => {
    if (index >= startIndex && index < endIndex) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });

  document.querySelector(".current-page").textContent = page;
}

document.querySelector(".prev-page").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
  }
});

document.querySelector(".next-page").addEventListener("click", () => {
  if (currentPage < totalPages) {
    currentPage++;
    showPage(currentPage);
  }
});

showPage(1);

// xóa 1 sản phẩm
function deleteProduct(productId) {
  var modal = document.getElementById("confirmModal");
  var btnYes = document.getElementById("confirmYes");
  var btnNo = document.getElementById("confirmNo");

  // Mở modal
  modal.style.display = "block";

  // Xử lý khi nhấn Có
  btnYes.onclick = function () {
    // Gửi yêu cầu xóa bằng AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ConnectDb.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Tải lại trang
        window.location.reload();
      } else {
        alert("Có lỗi xảy ra khi xóa sản phẩm.");
      }
    };
    xhr.send("deleteProduct=true&productId=" + productId);

    // Đóng modal
    modal.style.display = "none";
  };

  // Xử lý khi nhấn Không
  btnNo.onclick = function () {
    // Đóng modal

    modal.style.display = "none";
  };
}
