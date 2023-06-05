<?php

    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'users';
    $_SESSION['redirect_to'] = 'users-add.php';
   $user = $_SESSION['user'];
   $users = include('DATABASE/show.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Users - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
</head>
<body>
	<div id="dashboardMainContainer">		
		<?php include('partials/app-sidebar.php') ?>
				<div class="dashboard_content_container" id="dashboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<div class="row">
						<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-plus"></i>Insert User</h1>
							<div id="userAddFormContainer">
								<form action="DATABASE/add.php" method="POST" class="appForm" enctype="multipart/form-data">
									<div class="appFormInputContainer">
										<label for="position">Position</label>
										<select id="pos" name="position" >
											<option value="User">SELECT</option>
											<option value="Admin">ADMIN</option>
											<option value="User">USER</option>
										</select>
									</div>
									<div class="appFormInputContainer">
										<label for="first_name">First Name</label>
										<input type="text" class="appFormInput" name="first_name" id="first_name" /required>
									</div>
									<div class="appFormInputContainer">
										<label for="last_name">Last Name</label>
										<input type="text" class="appFormInput" name="last_name" id="last_name" /required>
									</div>
									<div class="appFormInputContainer">
										<label for="email">Email</label>
										<input type="email" class="appFormInput" name="email" id="email" /required>
									</div>
									<div class="appFormInputContainer">
										<label for="password">Password</label>
										<input type="password" class="appFormInput" name="password" id="password" /required>
									</div>
									<div class="appFormInputContainer">
										<label for="user_pic">User Image</label>
										<input type="file" name="user_pic"/required>
									</div>
									<button type="submit" name="adduser" class="appBtn"><i class="fa fa-plus"></i> Add User</button>
								</form>
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
					</div>
				</div>
					</div>
					</div>
				</div>
		
		</div>
	</div>
	<?php include('partials/app-scripts-foradd.php'); ?>
	
</body>
</html>

