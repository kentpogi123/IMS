<?php

require('connection.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email,$v_code)
{
  require ("PHPMailer/PHPMailer.php");
  require ("PHPMailer/SMTP.php");
  require ("PHPMailer/Exception.php");

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'lacanariaquekeneth46@gmail.com';                     
    $mail->Password   = 'sikx lwsk xfxl gipr';                              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
    $mail->Port       = 587;                                     
    $mail->setFrom('lacanariaquekeneth46@gmail.com', 'QUEKENETH'); 
    $mail->addAddress($email);

    $mail->isHTML(true);                                 
    $mail->Subject = 'Email Verification from  QUEKENETH';
    $mail->Body    = "Thanks for registration! 
      Click the link below  verify the email address 
      <a href='http://localhost/php-HTML/verify.php?email=$email&v_code=$v_code'>Verify</a>";

    $mail->send();
    return true;
 } 
 catch (Exception $e){
   return false;
 }

}

#for login
if(isset($_POST['login']))
{
  $query="SELECT * FROM `registered_users` WHERE `email`='$_POST[email_username]' OR `username`='$_POST[email_username]'";
  $result=mysqli_query($con,$query);

  if($result)
  {
    if(mysqli_num_rows($result)==1)
    {
      $result_fetch=mysqli_fetch_assoc($result);
      if($result_fetch['is_verified']==1)
      {
      if(password_verify($_POST['password'],$result_fetch['password']))
      {
        #if password matched
        $_SESSION['logged_in']=true;
        $_SESSION['username']=$result_fetch['username'];
        header("location: dashboard.php");
      }
      else
      {
        #if password incorrect
        echo"
          <script>
            alert('Incorrect Password or Email');
            window.location.href='index1.php';
          </script>
        ";
      }
     }
     else
     {
       echo"
         <script>
           alert('Email Not Verified');
           window.location.href='index1.php';
         </script>
       ";
     }
    }
      
    else
    {
      echo"
        <script>
          alert('Email or Password Not Registered');
          window.location.href='index1.php';
        </script>
      ";
    }
  }
  else
  {
    echo"
      <script>
        alert('Cannot Run Query');
        window.location.href='index1.php';
      </script>
    ";
  }
}


#for registration
if(isset($_POST['register']))
{
  $user_exist_query="SELECT * FROM `registered_users` WHERE `username`='$_POST[username]' OR `email`='$_POST[email]'";
  $result=mysqli_query($con,$user_exist_query);

  if($result)
  {
    if(mysqli_num_rows($result)>0) #it will be executed if username or email is already taken
    {
      $result_fetch=mysqli_fetch_assoc($result);
      if($result_fetch['username']==$_POST['username'])
      {
        #error for username already registered
        echo"
          <script>
            alert('$result_fetch[username] - Username already taken');
            window.location.href='index1.php';
          </script>
        ";
      }
      else
      {
        #error for email already registered
        echo"
          <script>
            alert('$result_fetch[email] - E-mail already registered');
            window.location.href='index1.php';
          </script>
        ";
      }
    }
    else #it will be executed if no one has taken username or email before
    {
      $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
      $v_code=bin2hex(random_bytes(16));

      $query="INSERT INTO `registered_users`(`full_name`, `username`, `email`, `password`, `verification_code`, `is_verified`) VALUES ('$_POST[full_name]','$_POST[username]','$_POST[email]','$password','$v_code','0')";

      if(mysqli_query($con,$query) && sendMail($_POST['email'],$v_code))
      {

        echo"
          <script>
            alert('Registration Successful');
            window.location.href='index1.php';
          </script>
        ";
      }
      else
      {
        #if data cannot be inserted
        echo"
          <script>
            alert('Server Down');
            window.location.href='index1.php';
          </script>
        ";
      }
    }
  }
  else
  {
  	echo"
  	  <script>
  	    alert('Cannot Run Query');
  	    window.location.href='index1.php';
  	  </script>
  	";
  }
}

?>