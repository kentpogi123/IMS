<?php
    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'tablewares';
  $_SESSION['redirect_to'] = 'tableware-add.php';
  $tablewares = include('DATABASE/show.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Equipments - Inventory Management System</title>
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
							<h1 class="section_header"><i class="fa fa-plus"></i>Add Inventotry Plates and Cups</h1>
							<div id="userAddFormContainer">
								<form action="DATABASE/add.php" method="POST" class="appForm" enctype="multipart/form-data" >
									<div class="appFormInputContainer0">
										<label for="PC_tableware">Equipment Name</label>
										<input type="text" class="appFormInput" placeholder="Name of Equipment" name="PC_tableware" id="product_name" /required>
									</div>
									<div class="appFormInputContainer1">
 										<label for="tableware_type">type plate or cup</label>
										<select name="tableware_type" id="producttypeSelect">
											<option value="">SELECT TYPE</option>
											<option value="PLASTIC">PLASTIC</option>
											<option value="GLASS">GLASS</option>
											<option value="RUBBER">RUBBER</option>
										</select>
									</div>
									<div class="appFormInputContainer4">
									<label id="labelquantity" for="quantity">Quantity</label>
										<input class="appFormInputquantity" type="number" name="quantity" placeholder="Enter Quantity">
									</div>
									<div class="appFormInputContainer4">
									<label id="labelquantity" for="unit">Quantity Unit</label>
										<input class="appFormInputquantity" type="text" name="unit" placeholder="Enter Quantity">
									</div>
									<div class="appFormInputContainer5">
										<label for="tableware_pic">Equipment Image</label>
										<input type="file" name="tableware_pic"/>
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

