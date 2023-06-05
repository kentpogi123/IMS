<?php
    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
$_SESSION['redirect_to'] = 'users-view-minimizep.php';
   $user = $_SESSION['user'];
   $_SESSION['table'] = 'users';
   $users = include('DATABASE/show.php');
?>
<!DOCTYPE html>
<html>
<head>

	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Users - Inventory Management System</title>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar-2.php') ?>
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
							<h1 class="section_header"><i class="fa fa-list"></i>list of Users
							<div class="dataTables_filter" id="manageProductTable_filter">
								<label>
									Search
									<input type="search" id="live_search2"  onclick="fadeaway()" autocomplete="off" value="" aria-controls="manageProductTable">
								</label>
								<div class="SeePIC">
								<span><a href="users-view.php"><i class="fa fa-image"></i>W/PICTURES</a></span>
							</div>
							</div>
						</h1>
							<div id="searchresult2"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th>#</th>
											<th>POSITION</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Email</th>
											<th>Password</th>
											<th>Created At</th>
											<th>Updated At </th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
											<?php
												foreach ($users as $index => $user){
											?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td><?=$user['position']?></td>
												<td class="firstName"><?=$user['first_name']?></td>
												<td class="lastName"><?=$user['last_name']?></td>
												<td class="email"><?=$user['email']?></td>
												<td class="password"><?= $user['password'] ?></td>
												<td><?= date('M d, Y @ h:i:s A', strtotime( $user["created_at"]))?></td>
												<td><?= date('M d, Y @ h:i:s A', strtotime($user["update_at"])) ?></td>
												<td>
												<a href="" class="updateUser" data-userid="<?= $user['id'] ?>"><i class="fa fa-pencil"></i>EDIT</a>
												<a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name']?>" data-lname="<?= $user['last_name']?>"><i class="fa fa-trash"></i>DELETE</a>
												</td>
											</tr>
										     <?php } ?>
										</tbody>
									</table>
									<p class="userCount"><?= count($users) ?> Users</p>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
		
		</div>
	</div>
		<?php include('partials/app-scripts.php'); ?>
		<script src="js/searchbaruserminimize.js"></script>
		<script src="js/updateuserpic.js"></script>
		<script src="js/updateuser.js"></script>
			
	<script>		
			// function script(){

			// 	this.initialize = function(){
			// 		this.registerEvents();
			// 	},															

			// 	this.registerEvents = function(){
			// 		document.addEventListener('click', function(e){
			// 			targetElement = e.target;
			// 			classList = targetElement.classList;


			// 			if(classList.contains('deleteUser')){
			// 				e.preventDefault();
			// 				userId = targetElement.dataset.userid;
			// 				fname = targetElement.dataset.fname;
			// 				lname = targetElement.dataset.lname;
			// 				fullName = fname + ' ' + lname;

			// 				BootstrapDialog.confirm({
			// 					type: BootstrapDialog.TYPE_DANGER,
			// 					title: 'Delete User',
			// 					message: 'Are you sure to delete <strong>' + fullName + '</strong>?',
			// 					callback: function(isDelete){
			// 						if(isDelete){
			// 					$.ajax({
			// 						method: 'POST',
			// 						data: {
			// 							id: userId,
			// 							table: 'users'
			// 						},
			// 						url:'DATABASE/delete.php',
			// 						dataType: 'json',
			// 						success: function(data){
			// 							message = data.success ?
			// 								fullName + ' successfully deleted!' : ' Error processing your request!';


			// 								BootstrapDialog.alert({
			// 									type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
			// 									message:message,
			// 									callback: function(){
			// 										if(data.success)location.reload();
			// 									}
			// 								});
										
			// 						}
			// 					});
			// 				}
			// 					}
			// 				});
						
			// 			}
			// 			if(classList.contains('updateUser')){
			// 				e.preventDefault();
							

			// 			firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
			// 			lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
			// 			email = targetElement.closest('tr').querySelector('td.email').innerHTML;
			// 			password = targetElement.closest('tr').querySelector('td.password').innerHTML;
			// 			userId = targetElement.dataset.userid;


			// 			BootstrapDialog.confirm({
			// 				title: 'CHANGE USER INFO ' + firstName + ' ' + lastName,
			// 				message: '<form>\
			// 				<div class="form-group">\
			// 					<label for="firstName">First Name:</label>\
			// 					<input type="text" class="form-control" id="firstNameUpdate" value="' + firstName + '">\
			// 				</div>\
			// 				<div class="form-group">\
			// 					<label for="lastName">Last Name:</label>\
			// 					<input type="text" class="form-control" id="lastNameUpdate" value="' + lastName + '">\
			// 				</div>\
			// 				<div class="form-group">\
			// 					<label for="email"> email:</label>\
			// 					<input type="email" class="form-control" id="emailUpdate" value="' + email + '">\
			// 				</div>\
			// 				<div class="appFormInputContainer">\
			// 							<label for="password">Password</label>\
			// 							<input type="password" class="form-control"  id="passwordUpdate" value="' + password + '">\
			// 						</div>\
			// 			</form>',
			// 			callback: function(isUpdate){
			// 				if(isUpdate){
			// 					$.ajax({
			// 						method: 'POST',
			// 						data: {
			// 							userId: userId,
			// 							f_name: document.getElementById('firstNameUpdate').value,
			// 							l_name: document.getElementById('lastNameUpdate').value,
			// 							email: document.getElementById('emailUpdate').value,
			// 							password: document.getElementById('passwordUpdate').value,
			// 						},
			// 						url:'DATABASE/update-user.php',
			// 						dataType: 'json',
			// 						success: function(data){
			// 							if(data.success){
			// 								BootstrapDialog.alert({
			// 									type: BootstrapDialog.TYPE_SUCCESS,
			// 									message: data.message,
			// 									callback: function(){
			// 										location.reload();
			// 									}
			// 								});
			// 							}else
			// 							 BootstrapDialog.alert({
			// 									type: BootstrapDialog.TYPE_DANGER,
			// 									message: data.message,
			// 								});
			// 						}
			// 					}); 
			// 				}
			// 			}
			// 			});
			// 			}
			// 		});
			// 	}
			// }
			// var script = new script;
			// script.initialize();

			function fadeaway(){
      document.getElementById('popup').style.display="none";
      document.getElementById('live_search').style.display="visible";
		}
		</script>
</body>
</html>

