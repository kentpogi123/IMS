<?php
session_start();
 date_default_timezone_set('Asia/Manila');
$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];

try {
    include('connect.php');

    $selectQuery = "SELECT * FROM $table WHERE id = {$id}";
    $selectStmt = $conn->query($selectQuery);
    $deletedRow = $selectStmt->fetch(PDO::FETCH_ASSOC);

    $command = "DELETE FROM $table WHERE id={$id}";
    $conn->exec($command);

    $log_message = 'DELETED row: ' . json_encode($deletedRow);

    // Insert log into the database
    $insertQuery = 'INSERT INTO activitylogs (user_id, action_made, created_at) VALUES (:user_id, :action_made, :created_at)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $_SESSION['user']['id']);
    $insertStmt->bindValue(':action_made', $log_message);
    $insertStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $insertStmt->execute();

    $response = [
        'success' => true,
        'message' => 'Successfully deleted to the system.'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => 'Error processing you request.'
    ];
}

$_SESSION['response'] = $response;
header('Location: ../' . $_SESSION['redirect_to']);
exit;


?>
