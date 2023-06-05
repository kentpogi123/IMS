<?php
session_start();
if (isset($_SESSION['user'])) {
    // User is already logged in, redirect to dashboard
    header('Location: indexdashboard.php');
    exit;
}

$error_message = '';

if ($_POST) {
    include('DATABASE/connect.php');

    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $img = $_POST['img'];
    $manufacture_date = $_POST['manufacture_date'];
    $expiration_date = $_POST['expiration_date'];
    $created_by = $_POST['created_by'];


    // Insert the product into the database
    $query = 'INSERT INTO products (product_name, product_type, quantity, unit, img, manufacture_date, expiration_date, created_by, created_at, updated_at) VALUES (:product_name, :product_type, :quantity, :unit, :img, :manufacture_date, :expiration_date, :created_by, :created_at, :updated_at)';
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':product_name', $product_name);
    $stmt->bindValue(':product_type', $product_type);
    $stmt->bindValue(':quantity', $quantity);
     $stmt->bindValue(':unit', $unit);
    $stmt->bindValue(':img', $img);
    $stmt->bindValue(':manufacture_date', $manufacture_date);
     $stmt->bindValue(':expiration_date', $expiration_date);
    $stmt->bindValue(':created_by', $created_by);
    $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
    $stmt->execute();

    // Log product creation
    $product_id = $conn->lastInsertId();
    $log_message = 'Product "'.$product_name.'" (ID:'.$product_id.') created at "'.date('Y-m-d H:i:s').'"';

    // Insert log into the database
    $insertQuery = 'INSERT INTO activitylogs (user_id, action_made, created_at) VALUES (:user_id, :action_made, :created_at)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $_SESSION['user']['id']);
    $insertStmt->bindValue(':action_made', $log_message);
    $insertStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $insertStmt->execute();

    header('Location: indexdashboard.php');
    exit;
}
?>
