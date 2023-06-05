<?php
session_start();
// Assuming you have established a database connection and included the necessary files.

// Check if the delete request was sent
if (isset($_POST['delete'])) {
    try {
        include('connect.php');
        // Prepare the delete query
        $stmt = $conn->prepare("DELETE FROM loginlogs");

        // Execute the delete query
        $stmt->execute();

        // Check the affected rows
        $affectedRows = $stmt->rowCount();
        
        if ($affectedRows > 0) {
            $response = [ 
                'success' => true,
                'message' => 'Logs successfully deleted'
            ];
        } else {
            $response = [ 
                'success' => true,
                'message' => 'No activity logs found to delete.'
            ];
        }
    } catch (PDOException $e) {
        $response = [ 
                'success' => false,
                'message' => 'Error deleting logs.'
            ];
    }
    $_SESSION['response'] = $response;
header('Location: ../Logs-view.php');
}
?>
