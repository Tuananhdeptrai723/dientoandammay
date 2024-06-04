<?php
include 'ConnectDb.php';
session_start();

// Check if the product ID is set in the request
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Retrieve the product details from the database
    $sql = "SELECT ID, nameProducts, Price, Quantity FROM cart WHERE ID = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Store the product details in the session
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

        // You can also add the item to the cartorder table in the database
        $sql = "INSERT INTO ordercart (product_id, name, price, quantity) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdi", $row['ID'], $row['nameProducts'], $row['Price'], $row['Quantity']);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to the main page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>