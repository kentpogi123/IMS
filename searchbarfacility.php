<?php
     session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
   $_SESSION['table'] = 'facilities';
   $facilities = include('DATABASE/show.php');
   include("config.php");


if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = "SELECT * FROM facilities WHERE facility_pic LIKE '{$input}%' OR facility_name LIKE '{$input}%' OR state LIKE '{$input}%' OR description LIKE '{$input}%' OR status LIKE '{$input}%' OR created_by LIKE '{$input}%' OR created_at LIKE '{$input}%' OR updated_at LIKE '{$input}%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <thead>
                <tr>
                 <th>#</th>
                <th>Image</th>
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
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $facility_pic = $row['facility_pic'];
                $id = $row['id'];
                $facility_name = $row['facility_name'];
                $status = $row['status'];
                $state = $row['state'];
                $description = $row['description'];
                $created_by = $row['created_by'];
                $created_at = $row['created_at'];
                $updated_at = $row['updated_at'];
                $cssClass = ($state == 'LOST' || $state == 'DAMAGE') ? 'low-stock' : '';
            ?>
            <tr>
            <td><?= $index + 1 ?></td>
            <td class="userPic"><img class="productImages" src="facilitypic/facpic/<?= $facility_pic ?>"><a href="" class="updateFacilitypic " data-facilityid="<?= $id ?>"><i class="fa fa-image"></i>EDIT</a></td>
            <td class="Position"><?= $facility_name ?></td>
            <td><?= $status ?></td>
            <td class="firstName <?=$cssClass?>"><?=$state?></td>
            <td class="email"><?=$description?></td>
            <td>
            <?php
            $stmt = $conn->prepare("SELECT * FROM  users WHERE id=?");
            $stmt->execute([$created_by]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
            echo $created_by_name;
            ?>  
            </td>   
            <td><span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime( $created_at))?></span></span>
            <span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($updated_at))?></span></span></td>
            <td>
            <a href="" class="updateFacility" data-facilityid="<?= $id ?>"><i class="fa fa-pencil"></i>EDIT</a>
            <a href="" class="deleteFacility" data-facilityid="<?= $id ?>" data-fname="<?= $facility_name?>"><i class="fa fa-trash"></i>DELETE</a>
            </td>
        </tr>
            <?php
                $index++;
            }
            ?>
            </tbody>
        </table>
        <p class="userCount"><?= mysqli_num_rows($result) ?> facilities</p>
        <?php
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}
?>