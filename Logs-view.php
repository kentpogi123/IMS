<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'loginlogs';
   $loginlogs = include('DATABASE/show.php');


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Logs - Inventory Management System</title>
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
			 <div class="printcss">
				<button  onclick="deleteActivityLogs()">Delete Activity Logs</button>
				</div>
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<div class="row">
					
					<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-list"></i>list of Activity Logs
							</h1>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th width="2%">#</th>
											<th  width="15%">User name</th>
											<th>ACTION</th>
											<th width="15%">DATE</th>
											</tr>
										</thead>
										<tbody id="showdata">
											<?php

												foreach($loginlogs as $index => $loginlog){
													
											?>
											
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="lastName"><?php 
													$lid = $loginlog['user_id'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$lid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?> 
												</td>	
												<td class="lastName"><?=$loginlog['login_logout'] ?> </td>
												<td class="lastName"><?=date('M d, Y @ h:i:s A', strtotime( $loginlog['created_at']))?></td>
												
											</tr>
										     <?php } ?> 
										</tbody>
									</table>
									<p class="userCount"><?= count($loginlogs) ?> loginlogs</p>
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
	<!-- ...Existing HTML code... -->
<script>
function deleteActivityLogs() {
    if (confirm("Are you sure you want to delete all activity logs? This action cannot be undone.")) {
        // Create a form element dynamically
        var form = document.createElement("form");
        form.method = "post";
        form.action = "DATABASE/deletelogs.php";

        // Create an input element to hold the delete value
        var deleteInput = document.createElement("input");
        deleteInput.type = "hidden";
        deleteInput.name = "delete";
        deleteInput.value = "true";

        // Append the input element to the form
        form.appendChild(deleteInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<!-- ...Existing HTML code... -->

</body>
</html>

