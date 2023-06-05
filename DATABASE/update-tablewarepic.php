<?php
session_start();
date_default_timezone_set('Asia/Manila');
$PC_tableware = $_POST['PC_tableware'];
$tableware_type = $_POST['tableware_type'];
$quantity = $_POST['quantity'];
$g_condition = $_POST['g_condition'];
$missing = $_POST['missing'];
$damage = $_POST['damage'];
$unit = $_POST['unit'];

$tid = $_POST['tid'];


    $target_dir = "../tablewarepic/pics/";

$file_name_value = NULL;
$file_data = $_FILES['tableware_pic']; 

if($file_data['tmp_name'] !== ''){



    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'tableware-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
        
    if($check) {
        if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        }
    } 

}
       //update the product record
try {
	$sql = "UPDATE tablewares SET PC_tableware=?, tableware_type=?, quantity=?, g_condition=?, missing=?, damage=?, unit=?, tableware_pic=?, updated_at=? WHERE id=? ";
	include('connect.php');

	// Get the existing data before the update
    $selectQuery = "SELECT * FROM tablewares WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$facilityid]);
    $existingtableware= $selectStmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare($sql);
	$stmt->execute([$PC_tableware, $tableware_type, $quantity, $g_condition, $missing, $damage, $unit, $file_name_value,  date('Y-m-d h:i:s'), $tid]);

	$log_message = 'UPDATED Tableware Name "'.$PC_tableware.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingtableware).' NEW DATA: '.json_encode($_POST);

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
header('Location: ../tableware-view.php');
exit;
?>