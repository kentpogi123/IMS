<?php

    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');

   $user = $_SESSION['user'];

?>
man<html>
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
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					
				</div>
			</div>
		</div>
	</div>
	<?php include('partials/app-scripts.php'); ?>
</body>
</html>

