<?php
session_start();
date_default_timezone_set('Asia/Manila');
$product_name = $_POST['product_name'];
$product_type = $_POST['product_type'];
$quantity = $_POST['quantity'];
$unit = $_POST['unit'];
$manufacture_date = $_POST['manufacture_date'];
$expiration_date = $_POST['expiration_date'];
$pid = $_POST['pid'];

$target_dir = "../uploads/products/";

$file_name_value = NULL;
$file_data = $_FILES['img']; 

if($file_data['tmp_name'] !== ''){



    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'product-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
        
    if($check) {
        if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        }
    } 

}
    
       //update the product record
try {
	$sql = "UPDATE products SET product_name=?, product_type=?, quantity=?, unit=?, manufacture_date=?, expiration_date=?, img=?, updated_at=? WHERE id=? ";
	include('connect.php');

	// Get the existing data before the update
    $selectQuery = "SELECT * FROM products WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$pid]);
    $existingProduct = $selectStmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare($sql);
	$stmt->execute([$product_name, $product_type, $quantity, $unit, $manufacture_date, $expiration_date, $file_name_value, date('Y-m-d h:i:s'), $pid]);

	// Create log message with the old and new data
    $log_message = 'UPDATED Product Name "'.$product_name.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingProduct).' NEW DATA: '.json_encode($_POST);

 // Insert log into the database
    $insertQuery = 'INSERT INTO activitylogs (user_id, action_made, created_at) VALUES (:user_id, :action_made, :created_at)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $_SESSION['user']['id']);
    $insertStmt->bindValue(':action_made', $log_message);
    $insertStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $insertStmt->execute();

    $response=[
        'success' => true,
        'message' => 'Successfully updated.'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => 'Error processing your request!'
    ];
}

$_SESSION['response'] = $response;
header('Location: ../product-view.php');
exit;
?>