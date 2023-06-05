<?php

include('connect.php');

$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM  utensils WHERE id=$id");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($row);