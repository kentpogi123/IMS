<?php

$con = mysqli_connect("localhost","root","","inventory");

if(!$con){
	echo "Connection Failed" . mysqli_connect_error();
}
?>
