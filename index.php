<!DOCTYPE html>
<html>
<head>
  <?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/splashy.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>splash effect</title>
</head>
<body id="loadingpic">
	<div class="customersname">
 	<p>LYN'S CANTEEN INVENTORY MANAGEMENT SYSTEM</p>
 </div>
	<div class="splashlogo">
    <p>INVENTORY MANAGEMENT SYSTEM</p>
  </div>
  <div class="logopic">
<img src="pic/1234.jpg">
</div>
  <script>
    setTimeout(function() {
      window.location.href ="Login.php";
    }, 6000);
  </script>
</body>
</html>