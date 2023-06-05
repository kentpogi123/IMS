<?php

$product_name = $_POST['product_name'];
$product_type = $_POST['product_type'];
$quantity = $_POST['quantity'];
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
	$sql = "UPDATE products SET product_name=?, product_type=?, quantity=?, img=?, updated_at=? WHERE id=? ";
	include('connect.php');

	$stmt = $conn->prepare($sql);
	$stmt->execute([$product_name, $product_type, $quantity, $file_name_value, date('Y-m-d h:i:s'), $pid]);

	$response = [
		'success' => true,
		'message' => "<strong>$product_name</strong> successfully updated to the system."
	];
	
} catch (Exception $e) {
	$response = [
		'success' => false,
		'message' => "Error processing your request."
	];	
}

echo json_encode($response);