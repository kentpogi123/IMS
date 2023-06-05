<?php
session_start();
date_default_timezone_set('Asia/Manila');
$utensil_name = $_POST['utensil_name'];
$utensil_type = $_POST['utensil_type'];
$quantity = $_POST['quantity'];
$g_condition = $_POST['g_condition'];
$missing = $_POST['missing'];
$damage = $_POST['damage'];
$unit = $_POST['unit'];

$uid = $_POST['uid'];

$target_dir = "../utensilpic/pics/";

$file_name_value = NULL;
$file_data = $_FILES['utensil_pic']; 

if($file_data['tmp_name'] !== ''){



    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'utensil-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
        
    if($check) {
        if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        }
    } 

}
    
       //update the product record
try {
	$sql = "UPDATE utensils SET utensil_name=?, utensil_type=?, quantity=?, g_condition=?, missing=?, damage=?, unit=?, utensil_pic=?, updated_at=? WHERE id=? ";
	include('connect.php');
	// Get the existing data before the update
    $selectQuery = "SELECT * FROM utensils WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$uid]);
    $existingUtensil= $selectStmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare($sql);
	$stmt->execute([$utensil_name, $utensil_type, $quantity, $g_condition, $missing, $damage, $unit, $file_name_value, date('Y-m-d h:i:s'), $uid]);

	// Create log message with the old and new data
    $log_message = 'UPDATED Utensil Name "'.$utensil_name.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingUtensil).' NEW DATA: '.json_encode($_POST);

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
header('Location: ../utensil-view.php');
exit;
?>