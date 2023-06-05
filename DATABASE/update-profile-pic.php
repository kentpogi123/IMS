<?php
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$userid = $_POST['userid'];

$target_dir = "../UserUploads/UserPics/";

$file_name_value = NULL;
$file_data = $_FILES['user_pic']; 

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

		
		$sql = "UPDATE users SET first_name=?, last_name=?, email=?, user_pic=?, password=?, update_at=? WHERE id=?";
		include('connect.php');

		$stmt = $conn->prepare($sql);	
		$stmt->execute([$first_name, $last_name, $email, $file_name_value, $password, date('Y-m-d h:i:s'), $userid]);

		$response = [
			'success' => true,
			'message' => "successfully updated."
		];
	} catch (Exception $e) {
	$response = [
			'success' => false,
			'message' => "Error processing your request!"
		];
}
echo json_encode($response);