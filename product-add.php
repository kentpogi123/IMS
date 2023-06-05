<?php
    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'products';
  $_SESSION['redirect_to'] = 'product-add.php';
  $products = include('DATABASE/show.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Product - Inventory Management System</title>
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
							<h1 class="section_header"><i class="fa fa-plus"></i>Create Product</h1>
							<div id="userAddFormContainer">
								<form action="DATABASE/add.php" method="POST" class="appForm" enctype="multipart/form-data" >
									<div class="appFormInputContainer0">
										<label for="product_name">Product Name</label>
										<input type="text" class="appFormInput" placeholder="Enter Product Name" name="product_name" id="product_name" /required>
									</div>
									<div class="appFormInputContainer1">
 										<label for="product_type">Product type</label>
										<select name="product_type" id="producttypeSelect">
											<option value="">SELECT TYPE</option>
											<option value="RAW">RAW</option>
											<option value="DRIED GOODS">DRIED GOODS</option>
											<option value="WET GOODS">WET GOODS</option>
											<option value="SPICES">SPICES</option>
											<option value="VEGETABLES">VEGETABLES</option>
											<option value="CONDIMENTS">CONDIMENTS</option>
											<option value="PROCESS FOODS">PROCESS FOODS</option>
										</select>
									</div>
									<div class="appFormInputContainer4">
									<label id="labelquantity" for="quantity">Quantity</label>
										<input class="appFormInputquantity" type="number" name="quantity" placeholder="Enter Quantity">
									</div>
									<div class="appFormInputContainer4">
									<label id="labelquantity" for="unit">Quantity Unit</label>
										<input class="appFormInputquantity" type="quantity" name="unit" placeholder="Enter Unit">
									</div>
									<div class="appFormInputContainer2">
									<label id="labelMFG" for="manufacture_date">MFG</label>
										<input type="date" name="manufacture_date" class="appFormInputdate">
									</div>
									<div class="appFormInputContainer3">
									<label id="labelEXP" for="expiration_date">EXP</label>
										<input type="date" name="expiration_date" class="appFormInputdate">
									</div>
									<div class="appFormInputContainer5">
										<label for="img">Product Image</label>
										<input type="file" name="img"/>
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

