<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
  if(!isset($_SESSION['user'])) header('location:index.php');
   $_SESSION['redirect_to'] = 'utensil-viewmin.php';
  $_SESSION['table'] = 'utensils';
   $utensils = include('DATABASE/show.php');


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Utensils - Inventory Management System</title>
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
							<h1 class="section_header"><i class="fa fa-list"></i>List of Utensils
							<div class="dataTables_filter" id="manageProductTable_filter">
								<label>
									Search:
									<input type="search" id="live_search"  onclick="fadeaway()" autocomplete="off" value="" aria-controls="manageProductTable">
								</label>
								<div class="SeePIC">
								<span><a href="utensil-view.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
							</div>
							</div></h1>
							<div id="searchresult"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th width="2%">#</th>
											<th  width="10%">UTENSIL Name</th>
											<th width="10%">UTENSIL Type</th>
											<th width="10%">quantity</th>
											<th width="10%">GOOD CONDITION</th>
											<th>MISSING</th>
											<th>DAMAGE</th>
											<th width="12%">Create By</th>
											<th width="18%">Created By & Updated At </th>
											<th width="5%">Action</th>
										</tr>
										</thead>
										<tbody id="showdata">
											<?php

												foreach($utensils as $index => $utensil){
													$cssClass = ($utensil['quantity'] <= 30) ? 'low-stock' : '';
													$gnote = ($utensil['g_condition'] <=15) ? 'gnote' : '';
													$alert = ($utensil['missing'] >= 5) ? 'missing-alert' : '';
													$warning = ($utensil['damage'] >= 5) ? 'damage-alert' : '';
											?>
											
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="lastName"><?=$utensil['utensil_name'] ?> </td>	
												<td class="lastName"><?=$utensil['utensil_type'] ?> </td>
												<td class="lastName <?= $cssClass ?>"><?=$utensil['quantity'] ?><?= $utensil['unit'] ?></td>
												<td class="<?=$gnote?>"><?=$utensil['g_condition'] ?><?= $utensil['unit'] ?></td>		
												<td class="<?=$alert?>"><?=$utensil['missing'] ?><?= $utensil['unit'] ?></td>
												<td class="<?=$warning?>"><?=$utensil['damage'] ?><?= $utensil['unit'] ?></td>
												<td>
													<?php

													$uid = $utensil['created_by'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$uid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?>	
												</td>									
												<td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $utensil["created_at"]))?></span></span>
													<span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($utensil["updated_at"]))?></span></span></td>
												<td>
													<a href="" class="updateUtensil" data-uid="<?= $utensil['id'] ?>"><i class="fa fa-pencil"></i>EDIT</a>
													<a href="" class="deleteUtensil" data-utname="<?= $utensil['utensil_name'] ?>" data-uid="<?= $utensil['id'] ?>"><i class="fa fa-trash"></i>DELETE</a>
												</td>
											</tr>
										     <?php } ?> 
										</tbody>
									</table>
									<p class="userCount"><?= count($utensils) ?> utensils</p>
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
	<script src="js/utensil-searchbarmin.js"></script>
	<script src="js/utensilPic.js"></script>
	<script src="js/updateuserpic.js"></script>
	<script src="js/expiration.js"></script>
	<script src="js/utensilEditdata.js"></script>
</body>
</html>

