<?php
include 'ConnectDb.php';
session_start();

// Check if the product ID is set in the request
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    $sql = "SELECT ID, nameProducts, Price, Quantity FROM cart WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (!isset($_SESSION['cart_items'])) {
                $_SESSION['cart_items'] = array();
            }

            $item = array(
                'id' => $row['ID'],
                'name' => $row['nameProducts'],
                'price' => $row['Price'],
                'quantity' => $row['Quantity']
            );

            $_SESSION['cart_items'][] = $item;

            $sql = "INSERT INTO cartorder (product_id, name, price, quantity) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("isdi", $row['ID'], $row['nameProducts'], $row['Price'], $row['Quantity']);
                $stmt->execute();
                $stmt->close();
            } else {
                error_log("Failed to prepare statement for insert: " . $conn->error);
            }
        } else {
            error_log("Product not found with ID: " . $product_id);
        }

        $stmt->close();
    } else {
        error_log("Failed to prepare statement for select: " . $conn->error);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>