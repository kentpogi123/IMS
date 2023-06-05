<?php
session_start();
 date_default_timezone_set('Asia/Manila');
// Log user logout
if (isset($_SESSION['user'])) {
    include('DATABASE/connect.php');

    $logged_out_user = $_SESSION['user']['email'];
    $log_message = 'User "'.$logged_out_user.'" logged out at "'.date('Y-m-d H:i:s').'"';

    // Insert log into the database
    $insertQuery = 'INSERT INTO loginlogs (user_id, login_logout, created_at) VALUES (:user_id, :login_logout, :created_at)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $_SESSION['user']['id']);
    $insertStmt->bindValue(':login_logout', $log_message);
    $insertStmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $insertStmt->execute();

    unset($_SESSION['user']);
}

session_unset();
session_destroy();
header("location: index.php");

?>
