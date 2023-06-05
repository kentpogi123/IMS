<?php

include('connect.php');

$table_name = $_SESSION['table'];


$stmt = $conn->prepare("SELECT * FROM  $table_name ORDER BY created_at ASC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


return $stmt->fetchAll();
?>

