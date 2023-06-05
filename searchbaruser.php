<?php
     session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'users';
   $user = $_SESSION['user'];

   $_SESSION['table'] = 'users';
   $users = include('DATABASE/show.php');
   include("config.php");


if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = "SELECT * FROM users WHERE user_pic LIKE '{$input}%' OR first_name LIKE '{$input}%' OR last_name LIKE '{$input}%' OR email LIKE '{$input}%' OR password LIKE '{$input}%' OR created_at LIKE '{$input}%' OR update_at LIKE '{$input}%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <thead>
                <tr>
                   <th>#</th>
                   <th>Image</th>
                   <th>POSITION</th>
                   <th>First Name</th>
                   <th>Last Name</th>
                   <th>Email</th>
                   <th>Password</th>
                   <th width="30%">CREATED AT & Updated At </th>
                   <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $user_pic = $row['user_pic'];
                $id = $row['id'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $email = $row['email'];
                $password = $row['password'];
                $created_at = $row['created_at'];
                $update_at = $row['update_at'];
                $position = $row['position'];
            ?>
            <tr>
            <td><?= $index + 1 ?></td>
            <td><img class="productImages" src="UserUploads/UserPics/<?= $user_pic ?>" alt=""><a href="" class="updateUserpic" data-userid="<?= $user['id'] ?>"><i class="fa fa-image"></i>EDIT</a></td>
            <td><?=$position?></td>
            <td class="firstName"><?= $first_name?></td>
            <td class="lastName"><?= $last_name ?></td>
            <td class="email"><?= $email ?></td>
            <td class="email"><?= $password ?></td>
             <td><span id="date">CREATED BY: <span id="date0"><?= date('M d, y @ h:i:s A', strtotime($created_at))?></span></span><span id="date1">UPDATED AT: <span id="date2"><?= date('M d, y @ h:i:s A', strtotime($update_at)) ?></span></span></td>
            <td>
            <a href="" class="updateUser" data-userid="<?= $id ?>"><i class="fa fa-pencil"></i>EDIT</a>
            <a href="" class="deleteUser" data-userid="<?= $id ?>" data-fname="<?= $first_name ?>" data-lname="<?= $last_name ?>"><i class="fa fa-trash"></i>DELETE</a>
            </td>
        </tr>
            <?php
                $index++;
            }
            ?>
            </tbody>
        </table>
        <p class="userCount"><?= mysqli_num_rows($result) ?> users</p>
        <?php
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}
?>