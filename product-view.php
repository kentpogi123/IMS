<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
  if(!isset($_SESSION['user'])) header('location:index.php');
   $_SESSION['redirect_to'] = 'product-view.php';
  $_SESSION['table'] = 'products';
   $products = include('DATABASE/show.php');


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Products - Inventory Management System</title>
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
					<div class="row">
					
					<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-list"></i>List of Products
							<div class="dataTables_filter" id="manageProductTable_filter">
								<label>
									Search:
									<input type="search" id="live_search"  onclick="fadeaway()" autocomplete="off" value="" aria-controls="manageProductTable">
								</label>
								<div class="SeePIC">
								<span><a href="product-view-minimize.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
							</div>
							</div></h1>
							<div id="searchresult"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th width="2%">#</th>
											<th  width="8%">Image</th>
											<th  width="13%">Product Name</th>
											<th width="10%">Product Type</th>
											<th width="10%">quantity</th>
											<th width="20%">MANUFACTURE & EXPIRATION DATE</th>
											<th width="12%">Create By</th>
											<th width="20%">Created By & Updated At </th>
											<th width="8%">Action</th>
										</tr>
										</thead>
										<tbody id="showdata">
											<?php

												foreach($products as $index => $product){
													$cssClass = ($product['quantity'] <= 2) ? 'low-stock' : '';
											?>
											
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="firstName">
													<img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" /><a href="" class="updateProductpic" data-pid="<?= $product['id'] ?>"><i class="fa fa-image"></i>EDIT</a>
												</td>
												<td class="lastName"><?=$product['product_name'] ?> </td>	
												<td class="lastName"><?=$product['product_type'] ?> </td>
												<td class="lastName <?= $cssClass ?>"><?=$product['quantity'] ?><?= $product['unit'] ?></td>
												<td><span id="mfg1">MANUFACTURE @: <span id="mfg2"><?= date('M d, Y', strtotime( $product['manufacture_date']))?></span></span><span id="exp1"> EXPIRATION @: <span id="exp2"><?= date('M d, Y', strtotime( $product['expiration_date']))?></span></td>			
												<td>
													<?php

													$pid = $product['created_by'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$pid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?>	
												</td>									
												<td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $product["created_at"]))?></span></span>
													<span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($product["updated_at"]))?></span></span></td>
												<td>
													<a href="" class="updateProduct" data-pid="<?= $product['id'] ?>"><i class="fa fa-pencil"></i>EDIT</a>
													<a href="" class="deleteProduct" data-name="<?= $product['product_name'] ?>" data-pid="<?= $product['id'] ?>"><i class="fa fa-trash"></i>DELETE</a>
												</td>
											</tr>
										     <?php } ?> 
										</tbody>
									</table>
									<p class="userCount"><?= count($products) ?> products</p>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
		
		</div>
	</div>
		<?php include('partials/app-scripts.php'); ?>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/searchbar.js"></script>
	<script src="js/updateProductpic.js"></script>
	<script src="js/updateuserpic.js"></script>
	<script src="js/expiration.js"></script>

	<script>	

		function script(){
			var vm = this;

			this.registerEvents = function(){
			document.addEventListener('click', function(e){
						targetElement = e.target;
						classList = targetElement.classList;

						if(classList.contains('deleteProduct')){
							e.preventDefault();

							pId = targetElement.dataset.pid;
							pName = targetElement.dataset.name;


							BootstrapDialog.confirm({
								type: BootstrapDialog.TYPE_DANGER,
								title: 'Delete Product',
								message: 'Are you sure to delete <strong>' + pName + '<strong>?',
								callback: function(isDelete){
									if(isDelete){

								 var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'DATABASE/delete.php';

        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = pId;

        var inputTable = document.createElement('input');
        inputTable.type = 'hidden';
        inputTable.name = 'table';
        inputTable.value = 'products';

        form.appendChild(inputId);
        form.appendChild(inputTable);

        document.body.appendChild(form);
        form.submit();
      }
    }
  });
}


						if(classList.contains('updateProduct')){

							e.preventDefault();

							pId = targetElement.dataset.pid;

							
							vm.showEditDialog(pId);

						}

					// });

					// // document.addEventListener('submit', function(e){
					// // 	targetElement = e.target;

					// // 	alert(targetElement.id);
					// // 	e.preventDefault();
					// // });

					// $('#editProductForm').on('submit', function(e){
					// 	e.preventDefault();

					});
					document.addEventListener('submit', function(e){
						e.preventDefault();
						targetElement = e.target;

						if(targetElement.id === 'editProductForm'){
							targetElement.submit();
						}
					});
			}
			this.saveUpdateDate = function(form){
			// 					$.ajax({
			// 						method: 'POST',
			// 						data: new FormData(form) ,
			// 						url:'DATABASE/update-product.php',
			// 						processData: false,
			// 						contentType: false,
			// 						dataType: 'json',  
			// 						success: function(data){
			// 							BootstrapDialog.alert({
			// 								type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
			// 								message: data.message, 
			// 								callback: function(){
			// 									if(data.success) location.reload();
			// 								}
			// 							});
			// 						}
			// 					});

			// },

				form.submit(); };

			this.showEditDialog = function(id){


				$.get('DATABASE/get-product.php', {id: id}, function(productDetails){

					console.log(productDetails);
					BootstrapDialog.confirm({
							title: 'Update <strong>' + productDetails.product_name + '</strong>',
							message: '<form action="DATABASE/update-product.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
							<div class="appFormInputContainer">\
										<label for="product_name">Product Name</label>\
										<input type="text" class="appFormInput" value="'+ productDetails.product_name +'" placeholder="Enter Product Name" name="product_name" id="product_name" /required>\
										</div>\
										<div class="appFormInputContainer">\
										<label for="product_type">Product type</label>\
										<select name="product_type" id="producttypeSelect" >\
											<option value="'+ productDetails.product_type +'">SELECT TYPE</option>\
											<option value="RAW">RAW</option>\
											<option value="DRIED GOODS">DRIED GOODS</option>\
											<option value="WET GOODS">WET GOODS</option>\
											<option value="SPICES">SPICES</option>\
											<option value="VEGETABLES">VEGETABLES</option>\
											<option value="CONDIMENTS">CONDIMENTS</option>\
											<option value="PROCESS FOODS">PROCESS FOODS</option>\
										</select>\
									</div>\
									<div class="appFormInputContainer">\
									<label id="labelquantity" for="quantity">Quantity</label>\
										<input type="number" name="quantity" value="'+ productDetails.quantity +'">\
									</div>\
									<div class="appFormInputContainer4">\
									<label id="labelquantity" for="unit">Quantity Unit</label>\
										<input class="appFormInputquantity" type="quantity" name="unit" value="'+ productDetails.unit +'">\
									</div>\
									<div class="appFormInputContainer2">\
									<label id="labelMFG" for="manufacture_date">MFG</label>\
										<input type="date" name="manufacture_date" class="appFormInputdate" value="'+ productDetails.manufacture_date +'">\
									</div>\
									<div class="appFormInputContainer3">\
									<label id="labelEXP" for="expiration_date">EXP</label>\
										<input type="date" name="expiration_date" class="appFormInputdate" value="'+ productDetails.expiration_date +'">\
									</div>\
									<input type="hidden" name="pid" value="'+ productDetails.id +'"/>\
									<input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
									</form>\
							',

						callback: function(isUpdate){
							if(isUpdate){
								document.getElementById('editProductSubmitBtn').click();
					 
							}
						}
						});

				}, 'json');	

				 

			},



			this.initialize = function(){
				this.registerEvents();
			}

		}
		var script = new script;
		script.initialize();

		function fadeaway(){
      document.getElementById('popup').style.display="none";
      document.getElementById('live_search').style.display="visible";
		}



	</script>
</body>
</html>

