<?php

    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'facilities';
    $_SESSION['redirect_to'] = 'facility-add.php';
   $facilities = include('DATABASE/show.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Facility - Inventory Management System</title>
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
							<h1 class="section_header"><i class="fa fa-plus"></i>Create Equipments</h1>
							<div id="userAddFormContainer">
								<form action="DATABASE/add.php" method="POST" class="appForm" enctype="multipart/form-data" >
									<div class="appFormInputContainer6">
										<label for="facility_name">EQUIPMENT Name</label>
										<input type="text" class="appFormInput" placeholder="Enter Equipment Name" name="facility_name" id="product_name" /required>
									</div>
									<div class="appFormInputContainer7">
 										<label for="state">STATE</label>
										<select name="state" id="producttypeSelect">
											<option value="">SELECT STATE</option>
											<option value="GOOD CONDITION">GOOD CONDITION</option>
											<option value="FOUND">FOUND</option>
											<option value="FIXED">FIXED</option>
											<option value="LOST">LOST</option>
											<option value="DAMAGE">DAMAGE</option>
										</select>
									</div>
									<div class="appFormInputContainer8">
									<label id="labelquantity" for="description">DESCRIPTION</label>
									<textarea class="appFormInputquantity" name="description" ></textarea>
									</div>
									<div class="appFormInputContainer9">
 										<label for="status">STATUS</label>
										<select name="status" id="producttypeSelect">
											<option value="">SELECT STATUS</option>
											<option value="NEW">NEW</option>
											<option value="OLD">OLD</option>
										</select>
									</div>
									<div class="appFormInputContainer10">
										<label for="facility_pic">Equipment Image</label>
										<input type="file" name="facility_pic"/>
									</div>
									<button type="submit" class="appBtn"><i class="fa fa-plus"></i> Create Product</button>
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
