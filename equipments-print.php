<?php
    session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  date_default_timezone_set('Asia/Manila');
    $_SESSION['redirect_to'] = 'equipments-view.php';
   $_SESSION['table'] = 'equipments';
   $equipments = include('DATABASE/show.php');

?>
<!DOCTYPE html>
<html>
<head>

	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Equipments - Inventory Management System</title>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
				<div class="dashboard_content_container" id="dashboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			 <div class="printcss">
                <span class="printsee"><a href="equipments-print-minimize.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
                <button onclick="printPage()">Print</button>
            </div>
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<div class="row">
					
					<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-list"></i>List of Users</h1>
							<div id="searchresult2"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th width="2%">#</th>
											<th width="8%">Image</th>
											<th width="13%">Equipment name</th>
											<th width="5%">STATUS</th>
											<th width="8%">State</th>
											<th>Description</th>
											<th width="12%">Created By</th>
											<th width="20%">CREATED AT & Updated At </th>
										</tr>
										</thead>
										<tbody>
											<?php

												foreach ($equipments as $index => $equipment){
													$cssClass = ($equipment['state'] == 'LOST' || $equipment['state'] == 'DAMAGE') ? 'low-stock' : '';
											?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="userPic"><img class="productImages" src="Equipmentsuploads/ENpics/<?= $equipment['EN_img'] ?>"></td>
												<td class="Position"><?= $equipment['equipment_name'] ?></td>
												<td><?=$equipment['status']?></td>
												<td class="firstName <?=$cssClass?>"><?=$equipment['state']?></td>
												<td class="email"><?=$equipment['description']?></td>
												<td>
													<?php

													$equipmentid = $equipment['created_by'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$equipmentid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?>	
												</td>	
												<td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $equipment["created_at"]))?></span></span>
													<span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($equipment["updated_at"]))?></span></span></td>
											</tr>
										     <?php } ?>
										</tbody>
									</table>
									<p class="userCount"><?= count($equipments) ?> Equipments</p>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
		
		</div>
	</div>
		<?php include('partials/app-scripts.php'); ?>
		<script src="js/equipmentsupdate.js"></script>
		<script src="js/updateEquipmentPic.js"></script>
		<script src="js/searchbarequipments.js"></script>
		<script src="js/updateuserpic.js"></script>
		<script>
       function printPage() {
            window.print();
        }
    </script>
	<script>		
			function fadeaway(){
      document.getElementById('popup').style.display="none";
      document.getElementById('live_search').style.display="visible";
		}
		</script>
</body>
</html>

