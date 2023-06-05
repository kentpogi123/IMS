<?php
session_start();
date_default_timezone_set('Asia/Manila');
$equipmentid = $_POST['equipmentid'];
$equipment_name = $_POST['equipment_name'];
$state = $_POST['state'];
$description = $_POST['description'];
$status = $_POST['status'];

try {
    $sql = "UPDATE equipments SET equipment_name=?, status=?, state=?, description=?, updated_at=? WHERE id=?";
    include('connect.php');

    // Get the existing data before the update
    $selectQuery = "SELECT * FROM equipments WHERE id=?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->execute([$equipmentid]);
    $existingEquipment = $selectStmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare($sql);
    $stmt->execute([$equipment_name, $status, $state, $description, date('Y-m-d h:i:s'), $equipmentid]);

    // Create log message with the old and new data
    $log_message = 'UPDATED Equipment Name "'.$equipment_name.'" at "'.date('Y-m-d H:i:s').'". OLD DATA: '.json_encode($existingEquipment).' NEW DATA: '.json_encode($_POST);

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
header('Location: ../equipments-view.php');
header('location: ../' . $_SESSION['redirect_to']);
exit;
?>
