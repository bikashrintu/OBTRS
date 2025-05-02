<?php
session_start();

// Sample product data (in real-world scenario, this would come from a database)
$products = array(
    array("id" => 1, "name" => "Product 1", "price" => 10),
    array("id" => 2, "name" => "Product 2", "price" => 20),
    array("id" => 3, "name" => "Product 3", "price" => 15)
);

// Function to display products
function displayProducts($products) {
    echo "<h2>Products:</h2>";
    echo "<ul>";
    foreach ($products as $product) {
        echo "<li>{$product['name']} - \${$product['price']} <a href='?add={$product['id']}'>Add to Cart</a></li>";
    }
    echo "</ul>";
}

// Function to add item to cart
function addToCart($id) {
    $_SESSION['cart'][] = $id;
}

// Function to display cart
function displayCart($products) {
    echo "<h2>Shopping Cart:</h2>";
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        $total = 0;
        echo "<ul>";
        foreach ($_SESSION['cart'] as $itemId) {
            $item = array_filter($products, function ($product) use ($itemId) {
                return $product['id'] == $itemId;
            });
            $item = array_shift($item);
            $total += $item['price'];
            echo "<li>{$item['name']} - \${$item['price']}</li>";
        }
        echo "</ul>";
        echo "<p>Total: \$$total</p>";
        echo "<a href='?checkout=1'>Checkout</a>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}

// Process actions
if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    addToCart($_GET['add']);
}

// Display page content
echo "<h1>Welcome to our E-Commerce Store</h1>";

// Display products
displayProducts($products);

// Display cart
displayCart($products);

// Checkout
if (isset($_GET['checkout']) && $_GET['checkout'] == 1) {
    echo "<h2>Checkout</h2>";
    echo "<p>Thank you for your purchase!</p>";
    // Clear cart after checkout
    unset($_SESSION['cart']);
}

?>
