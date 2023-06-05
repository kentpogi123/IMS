
<?php

    session_start();
    if (isset($_SESSION['user'])) header('Location: indexdashboard.php');
    $error_message = '';

    if($_POST){
         include('DATABASE/connect.php');

        $USERNAME = $_POST['USERNAME'];
        $PASSWORD = $_POST['PASSWORD'];

        $query = 'SELECT * FROM users WHERE users.email="'. $USERNAME .'" AND users.PASSWORD="'. $PASSWORD .'"';
        $stmt = $conn->prepare($query);
       $stmt->execute();

       if($stmt->rowCount() > 0) {
           $stmt->setFetchMode(PDO::FETCH_ASSOC);
           $user = $stmt->fetchAll()[0];
           $_SESSION['user'] = $user;

           header('Location: indexdashboard.php');
        } else $error_message = ' Please make sure  that username and password are correct.';
   } ?>

<!DOCTYPE html>
<html>
<head>
	
	<title>IMS Login - Inventory Management System</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>
<body id ="Loginbody">
     <?php if(!empty($error_message)) { ?>
    <div id="ERRORDESIGN">
        <strong>ERROR:</strong> </p><?= $error_message ?> </p>
    </div>
    <?php } ?>
	<div class="customersname">
 	<p>LYN'S CANTEEN INVENTORY MANAGEMENT SYSTEM</p>
 </div>
	<div class="contents">
  	<div class="Headerlogin">
  		<h1>LOGIN</h1>
  		<h2>LYN's Canteen</h2>
  		<h3>Inventory Management System</h3></div>
    <div class="Loginbody">
  		<form action="login.php" method="POST" id="form">
  		<div class="logininput">
  			<label for="">USERNAME:</label>
  			<input placeholder="USERNAME" name="USERNAME" type="email"/required>
  		</div>
  		<div class="logininput">
  			<label for="">PASSWORD: </label>
  			<input placeholder="PASSWORD" name="PASSWORD" type="password" id="passinput"/required> 
  		</div>
        <div class="showpass">
        <i class="fa-solid fa-eye" id="eye"></i>
    </div>
  		<div class="loginbutton">
  			<button type="submit">LOGIN</button></div>
        </form>
        </div>
        <div class="logopic">
        <img src="pic/1234.jpg">
        </div>
        </div>
    <script>
        const passwordInput = document.querySelector("#passinput")
        const eye = document.querySelector("#eye")

        eye.addEventListener("click", function(){
        this.classList.toggle("fa-eye-slash")
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
        passwordInput.setAttribute("type", type)
})
</script>
</body>
</html>
   
