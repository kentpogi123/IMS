<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Password Update</title>
	<style>
	*{
	 margin: 0;
	 padding: 0;
	 box-sizing: border-box;
	 text-decoration: none;
	 font-family: popins;
	}
.pogi	img {
width: 100%;
height: 122vh;
}
	header h1{
	position: absolute;
	padding: 5px 20px;
	background: rgba(0,0,0,.5);
	text-align: center;
	border: 5px solid;
	color:#ffff00;
	font-size: 19px;
	margin-top: 10px;
	margin-left: 10px;
}
.hakdog img{
 position: absolute;
	width: 10%;
	border-radius: 100px;
	margin-top: -22%;
	margin-left: 89%;
	}

	form{
		position: absolute;
		margin-top: -42%;
		margin-left: 28%;
	background-color:rgba(0, 0, 0, .5);
	width: 600px;
	border: 5px solid #ffff00;
	padding: 20px 25px 30px 25px;
	}
	form h3{
	  margin-bottom: 15px;
	  color: #ffff00;
	}
	form input{
	width: 100%;
	margin-bottom: 20px;
	background-color: transparent;
	border: none;
	border-bottom: 2px solid #ffff00;
	border-radius: 0;
	padding: 5px 0;
	font-weight: 550;
	font-size: 14px;
	outline: none;
	color: #ffff00;
	}
	form button{
	font-weight: 1000;
	font-style: 15px;
	color: white;
	background-color: #ffff00;
	padding: 4px 10px;
	border: none;
	outline: none;
	margin-top: 5px;
	font-size: 15px;
	color: black;
	}
	</style>
</head>
<body>

<?php

require("connection.php");

if(isset($_GET['email']) && isset($_GET['reset_token']))
{
  date_default_timezone_set('Asia/Manila');
  $date=date("Y-m-d");
  $query="SELECT * from `registered_users` WHERE `email`='$_GET[email]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexpire`='$date'";
  $result=mysqli_query($con,$query);
  if($result)
  {
    if(mysqli_num_rows($result)==1)
    {
      echo "
      <header>
		<h1>LYN'S CANTEEN INVENTORY MANAGEMENT SYSTEM</h1>
		</header>
      <div class='pogi'>
      <img src='pic/FOOD.jpg'>
        <form method='POST'>
          <h3>Create New Password</h3>
          <input type='password' placeholder='Set NewPassword' name='Password'>
          <button type='submit' name='updatepassword'>UPDATE</button>
          <input type='hidden' name='email' value='$_GET[email]'>
        </form>
        </div>
        <div class='hakdog'>
        <img src='pic/logo.jpg'>
        </div>
      ";
    }
    else
    {
      echo "
	    <script>
		  alert('Invalid or Expired Link');
		  window.location.href='index1.php';
	    </script>
	  ";
    }
  }
  else
  {
    echo"
      <script>
	    alert('Server Down! try again later');
	    window.location.href='index1.php';
	  </script>
	";
  }
}

?>

<?php

  if(isset($_POST['updatepassword']))
  {
  	$pass=password_hash($_POST['Password'],PASSWORD_BCRYPT);
  	$update="UPDATE `registered_users` SET `password`='$pass',`resettoken`=NULL,`resettokenexpire`=NULL WHERE `email`='$_POST[email]'";
  	if(mysqli_query($con,$update))
  	{
      echo"
        <script>
	      alert('Password Upadated Successfully');
	      window.location.href='index1.php';
	    </script>
	  ";
  	}
  	else
  	{
      echo"
        <script>
	      alert('Server Down! try again later');
	      window.location.href='index1.php';
	    </script>
	  ";
  	}
  }

?>

</body>
</html>