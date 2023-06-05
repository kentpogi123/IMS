<?php

session_start();
if (isset($_SESSION["user"])) {
    header("Location: indexdashboard.php");
    exit;
}

$error_message = "";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$data = mysqli_connect($host, $username, $password, $dbname);
if ($data === false) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST["USERNAME"];
    $password = $_POST["PASSWORD"];

    $sql = "SELECT * FROM users WHERE email='$username' AND PASSWORD='$password'";

    $result = mysqli_query($data, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        if ($row["position"] == "Admin") {
            $_SESSION["USERNAME"] = $username;
            header("Location: dashboard.php");
            exit;
        } else if ($row["position"] == "User") {
            $_SESSION["USERNAME"] = $username;
            echo "user";
        }
    } else {
        $error_message = "Please make sure that the username and password are correct.";
    }
}

mysqli_close($data);

?>