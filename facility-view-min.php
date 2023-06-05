<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
  if(!isset($_SESSION['user'])) header('location:index.php');
   $_SESSION['redirect_to'] = 'facility-view-min.php';
  $_SESSION['table'] = 'facilities';
   $facilities = include('DATABASE/show.php');


?>
<!DOCTYPE html>
<html>
<head>

	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Equipments - Inventory Management System</title>
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
							<h1 class="section_header"><i class="fa fa-list"></i>List of Equipments Facility
							<div class="dataTables_filter" id="manageProductTable_filter">
								<label>
									Search
									<input type="search" id="live_search2"  onclick="fadeaway()" autocomplete="off" value="" aria-controls="manageProductTable">
								</label>
								<div class="SeePIC2">
								<span><a href="facility-view.php"><i class="fa fa-image"></i>W/PICTURES</a></span>
							</div>
							</div></h1>
							<div id="searchresult2"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th>#</th>
											<th width="10%">Equipment name</th>
											<th>STATUS</th>
											<th>State</th>
											<th width="20%">Description</th>
											<th>Created By</th>
											<th width="20%">CREATED AT & Updated At </th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
											<?php

												foreach ($facilities as $index => $facility){
													$cssClass = ($facility['state']=='LOST' || $facility['state']=='DAMAGE') ? 'low-stock' : '';
											?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="Position"><?= $facility['facility_name'] ?></td>
												<td><?= $facility['status'] ?></td>
												<td class="firstName <?=$cssClass?>"><?=$facility['state']?></td>
												<td class="email"><?=$facility['description']?></td>
												<td>
													<?php

													$facilityid = $facility['created_by'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$facilityid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?>	
												</td>	
												<td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $facility["created_at"]))?></span></span>
													<span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($facility["updated_at"]))?></span></span></td>
												<td>
												<a href="" class="updateFacility" data-facilityid="<?= $facility['id'] ?>"><i class="fa fa-pencil"></i>EDIT</a>
												<a href="" class="deleteFacility" data-facilityid="<?= $facility['id'] ?>" data-fname="<?= $facility['facility_name']?>"><i class="fa fa-trash"></i>DELETE</a>
												</td>
											</tr>
										     <?php } ?>
										</tbody>
									</table>
									<p class="userCount"><?= count($facilities) ?> facility</p>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
		
		</div>
	</div>
		<?php include('partials/app-scripts.php'); ?>
		<script src="js/FacilityEditDel.js"></script>
		<script src="js/updatefacilitypic.js"></script>
		<script src="js/facilitysearchbarmin.js"></script>
		<script src="js/updateuserpic.js"></script>

	<script>		
			function fadeaway(){
      document.getElementById('popup').style.display="none";
      document.getElementById('live_search').style.display="visible";
		}
		</script>
</body>
</html>

