<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
  if(!isset($_SESSION['user'])) header('location:index.php');
   $_SESSION['redirect_to'] = 'tableware-view.php';
  $_SESSION['table'] = 'tablewares';
   $tablewares = include('DATABASE/show.php');


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<?php include('partials/app-header-scripts.php'); ?>
	<title>View Tablewares - Inventory Management System</title>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
				<div class="dashboard_content_container" id="dashboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			 <div class="printcss">
                <span class="printsee"><a href="tableware-print-minimize.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
                <button onclick="printPage()">Print</button>
            </div>
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
							<h1 class="section_header"><i class="fa fa-list"></i>List of Plates and Cups</h1>
							<div id="searchresult"></div>
							<div class="section_content" id="popup">
								<div class="users">
									<table>
										<thead>
										<tr>
											<th width="2%">#</th>
											<th  width="8%">Image</th>
											<th  width="10%">EQUIPMENT Name</th>
											<th width="10%">EQUIPMENT Type</th>
											<th width="10%">quantity</th>
											<th width="10%">GOOD CONDITION</th>
											<th>MISSING</th>
											<th>DAMAGE</th>
											<th width="12%">Create By</th>
											<th width="18%">Created By & Updated At </th>
											</tr>
										</thead>
										<tbody id="showdata">
											<?php

												foreach($tablewares as $index => $tableware){
													$cssClass = ($tableware['quantity'] <= 30) ? 'low-stock' : '';
													$gnote = ($tableware['g_condition'] <=15) ? 'gnote' : '';
													$alert = ($tableware['missing'] >= 5) ? 'missing-alert' : '';
													$warning = ($tableware['damage'] >= 5) ? 'damage-alert' : '';

											?>
											
											<tr>
												<td><?= $index + 1 ?></td>
												<td class="firstName">
													<img class="productImages" src="tablewarepic/pics/<?= $tableware['tableware_pic'] ?>" alt="" />
												</td>
												<td class="lastName"><?=$tableware['PC_tableware'] ?> </td>	
												<td class="lastName"><?=$tableware['tableware_type'] ?> </td>
												<td class="lastName <?= $cssClass ?>"><?=$tableware['quantity'] ?><?= $tableware['unit'] ?></td>
												<td class="<?=$gnote?>"><?=$tableware['g_condition'] ?><?= $tableware['unit'] ?></td>		
												<td class="lastName <?= $warning ?>"><?=$tableware['damage'] ?><?= $tableware['unit'] ?></td>
												<td class="lastName <?= $alert ?>"><?=$tableware['missing'] ?><?= $tableware['unit'] ?></td>
												<td>
													<?php

													$tid = $tableware['created_by'];
													$stmt = $conn->prepare("SELECT * FROM  users WHERE id=$tid");
													$stmt->execute();
													$row = $stmt->fetch(PDO::FETCH_ASSOC);

													$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
													echo $created_by_name;
													?>	
												</td>									
												<td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $tableware["created_at"]))?></span></span>
													<span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($tableware["updated_at"]))?></span></span></td>
											</tr>
										     <?php } ?> 
										</tbody>
									</table>
									<p class="userCount"><?= count($tablewares) ?> products</p>
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
	<script src="js/tableware-searchbar.js"></script>
	<script src="js/tablewarePic.js"></script>
	<script src="js/updateuserpic.js"></script>
	<script src="js/expiration.js"></script>
	<script src="js/tablewareEditDel.js"></script>
	<script>
       function printPage() {
            window.print();
        }
    </script>
</body>
</html>

