<?php
// Assuming you have a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve the activity logs from the database
$query = "SELECT * FROM activitylogs ORDER BY created_at DESC";
$result = $conn->query($query);

// Display the activity logs
while ($row = $result->fetch_assoc()) {
    echo "User ID: " . $row['user_id'] . "<br>";
    echo "Action Made: " . $row['action_made'] . "<br>";
    echo "Created At: " . $row['created_at'] . "<br>";
    echo "<br>";
}

// Close the database connection
$conn->close();
?>
