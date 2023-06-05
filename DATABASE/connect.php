<?php
$servername = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';


try {
    $conn = new PDO("mysql:host=$servername;dbname=inventory", $USERNAME, $PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
    $error_message = $e->getMessage();
}
?>

