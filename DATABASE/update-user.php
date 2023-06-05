<?php
session_start();
	date_default_timezone_set('Asia/Manila');
 	$userid = $_POST['userid'];
 	$first_name = $_POST['first_name'];
 	$last_name = $_POST['last_name'];
 	$email = $_POST['email'];
 	$password = $_POST['password'];

 	try {
		
		$sql = "UPDATE users SET email=?, first_name=?, last_name=?, password=?, update_at=? WHERE id=?";
		include('connect.php');

		    // Get the existing data before the update
    $selectQuery = "SELECT * FROM users WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$userid]);
    $existingUser = $selectStmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare($sql);
		$stmt->execute([$email, $first_name, $last_name, $password, date('Y-m-d h:i:s'), $userid]);	

		// Create log message with the old and new data
    $log_message = 'UPDATED Equipment Name "'.$first_name.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingUser).' NEW DATA: '.json_encode($_POST);

    // Insert log into the database
    $insertQuery = 'INSERT INTO activitylogs (user_id, action_made, created_at) VALUES (:user_id, :action_made, :created_at)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $_SESSION['user']['id']);
    $insertStmt->bindValue(':action_made', $log_message);
    $insertStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $insertStmt->execute();

		$response=[
			'success' => true,
			'message' => 'successfully updated.'
		];
	} catch (PDOException $e) {
	$response =[
			'success' => false,
			'message' => 'Error processing your request!.'
		];
}
$_SESSION['response'] = $response;
header('Location: ../equipments-view.php');
header('location: ../' . $_SESSION['redirect_to']);
exit;
?>
		