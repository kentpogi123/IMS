<?php

    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
$_SESSION['redirect_to'] = 'dashboard.php';
   $user = $_SESSION['user'];
$_SESSION['table'] = 'products';
$products = include('DATABASE/show.php');
include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	
	<title>DASHBOARDWEBSITE</title>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
				<div class="dashboard_content_container" id="dashboard_content_container">
			<?php include('partials/app-topnav.php') ?>
            <?php 
                                    if(isset($_SESSION['response'])){

                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                ?>
                                    <div class="responseMessage">
                                        <p class="responseMessage <?= $is_success ? 'reponseMessage_success' : 'reponseMessage_error' ?>">
                                            <?= $response_message ?>
                                        </p>
                                    </div>
                                <?php unset($_SESSION['response']);} ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<?php
						// Step 1: Define low stock threshold
// Step 1: Define low stock threshold
$lowStockThreshold = 3;

 // Step 2: Retrieve products from the database
    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    // Step 3: Initialize count variables
    $lowStockCount = 0;       // Count of low stock items
    $expiringCount = 0;       // Count of expiring items
    $expiredCount = 0;        // Count of expired items

    while ($row = mysqli_fetch_assoc($result)) {
        $quantity = $row['quantity'];
        $expirationDate = strtotime($row['expiration_date']);
        $today = strtotime(date('Y-m-d'));

        // Step 4: Update count variables
        if ($quantity < $lowStockThreshold) {
            $lowStockCount++;
        }

        if ($expirationDate !== false) {
            if ($expirationDate >= $today && $expirationDate <= strtotime('+1 month')) {
                $expiringCount++;
            } elseif ($expirationDate < $today) {
                $expiredCount++;
            }
        }
    }


					 ?>
					 <?php if ($lowStockCount > 0): ?>
        <a href="product-view.php" class="notification-icon">Low Stock <span class="notification-count"><?= $lowStockCount ?></span></a>
    <?php else: ?>
        <span class="notification-icon">Low Stock <span class="notification-count">0</span></span>
    <?php endif; ?>

    <!-- Expiring Products Notification -->
    <?php if ($expiringCount > 0): ?>
        <a href="product-view.php" class="notification-icon">Expiring <span class="notification-count"><?= $expiringCount ?></span></a>
    <?php else: ?>
        <span class="notification-icon">Expiring <span class="notification-count">0</span></span>
    <?php endif; ?>

    <!-- Expired Products Notification -->
    <?php if ($expiredCount > 0): ?>
        <a href="product-view.php" class="notification-icon">Expired <span class="notification-count"><?= $expiredCount ?></span></a>
    <?php else: ?>
        <span class="notification-icon">Expired <span class="notification-count">0</span></span>
    <?php endif; ?>

				</div>
			</div>
		</div>
	</div>
	<?php include('partials/app-scripts.php'); ?>
    <script src="js/updateuserpic.js"></script>
    
</body>
</html>

