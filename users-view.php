<?php
    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  date_default_timezone_set('Asia/Manila');
  $_SESSION['redirect_to'] = 'users-view.php';
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
							<h1 class="section_header"><i class="fa fa-list"></i>list of Users
							<div class="dataTables_filter" id="manageProductTable_filter">
								<label>
									Search
									<input type="search" id="live_search2"  onclick="fadeaway()" autocomplete="off" value="" aria-controls="manageProductTable">
								</label>
								<div class="SeePIC2">
								<span><a href="users-view-minimizep.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
							</div>
							</div></h1>
							<div id="searchresult2"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th>#</th>
											<th>Image</th>
											<th>Position</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Email</th>
											<th>Password</th>
											<th width="30%">CREATED AT & Updated At </th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
											<?php

												foreach ($users as $index => $user){
											?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="userPic"><img class="productImages" src="UserUploads/UserPics/<?= $user['user_pic'] ?>"><a href="" class="updateUserpic" data-userid="<?= $user['id'] ?>"><i class="fa fa-image"></i>EDIT</a></td>
												<td class="Position"><?= $user['position'] ?></td>
												<td class="firstName"><?=$user['first_name']?></td>
												<td class="lastName"><?=$user['last_name']?></td>
												<td class="email"><?=$user['email']?></td>
												<td class="password"><?= $user['password'] ?></td>
												<td><span id="date">CREATED BY: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $user["created_at"]))?></span></span><span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($user["update_at"])) ?></span></span></td>
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
		<script src="js/searchbaruser.js"></script>
		<script src="js/updateuser.js"></script>
		<script src="js/updateuserpic.js"></script>
		
	<script>		
			function fadeaway(){
      document.getElementById('popup').style.display="none";
      document.getElementById('live_search').style.display="visible";
		}
		</script>
</body>
</html>

