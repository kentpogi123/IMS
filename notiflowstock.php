<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:index.php');
}
$_SESSION['table'] = 'products';
$products = include('DATABASE/show.php');
include("config.php");

// Step 1: Define low stock threshold
$lowStockThreshold = 10;

// Step 2: Retrieve products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

// Step 3: Iterate through the products
$lowStockCount = 0; // Variable to store the count of low stock items

while ($row = mysqli_fetch_assoc($result)) {
    $quantity = $row['quantity'];

    // Step 4: Update low stock count
    if ($quantity < $lowStockThreshold) {
        $lowStockCount++;
    }
}

// Step 5: Display icon notification with count
if ($lowStockCount > 0) {
    echo "<a href='low_stock_products.php' class='notification-icon'>Low Stock <span class='notification-count'>{$lowStockCount}</span></a>";
} else {
    echo "<span class='notification-icon'>Low Stock <span class='notification-count'>0</span></span>";
}
?>
