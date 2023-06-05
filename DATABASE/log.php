<?php
$data = $_POST;
$equipmentId = (int) $data['id'];

try {
    include('connect.php');

    // Retrieve equipment details before deletion
    $selectQuery = "SELECT * FROM equipments WHERE id = :id";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bindValue(':id', $equipmentId, PDO::PARAM_INT);
    $selectStmt->execute();
    $equipment = $selectStmt->fetch(PDO::FETCH_ASSOC);

    // Delete the equipment
    $deleteQuery = "DELETE FROM equipments WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindValue(':id', $equipmentId, PDO::PARAM_INT);
    $deleteStmt->execute();

    if ($deleteStmt->rowCount() > 0) {
        // Log the deletion action
        $logMessage = 'Equipment deleted: ID=' . $equipment['id'] . ', Name=' . $equipment['name'] . ', Type=' . $equipment['type'];
        $logQuery = "INSERT INTO activitylogs (action, created_at) VALUES (:action, :created_at)";
        $logStmt = $conn->prepare($logQuery);
        $logStmt->bindValue(':action', $logMessage);
        $logStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
        $logStmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Deletion logged successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Equipment not found or could not be deleted.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing your request: ' . $e->getMessage()
    ]);
}
?>
