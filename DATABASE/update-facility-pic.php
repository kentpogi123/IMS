<?php
session_start();
	date_default_timezone_set('Asia/Manila');
 	$facilityid = $_POST['facilityid'];
 	$facility_name = $_POST['facility_name'];
 	$state = $_POST['state'];
 	$status = $_POST['status'];
 	$description = $_POST['description'];

$target_dir = "../facilitypic/facpic/";
$file_name_value = NULL;
$file_data = $_FILES['facility_pic']; 

if($file_data['tmp_name'] !== ''){



    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'equipment-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
        
    if($check) {
        if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        }
    } 

}

 	try {
		
		$sql = "UPDATE facilities SET facility_name=?, state=?, description=?, status=?, facility_pic=?, updated_at=? WHERE id=?";
		include('connect.php');

		// Get the existing data before the update
    $selectQuery = "SELECT * FROM facilities WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$facilityid]);
    $existingFacility = $selectStmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare($sql);
		$stmt->execute([$facility_name, $state, $description, $status,  $file_name_value, date('Y-m-d h:i:s'), $facilityid]);	
// Create log message with the old and new data
    $log_message = 'UPDATED Facility Name "'.$facility_name.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingFacility).' NEW DATA: '.json_encode($_POST);

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
header('Location: ../facility-view.php');
exit;
?>
		