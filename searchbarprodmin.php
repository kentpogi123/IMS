<?php
 session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'products';
   $products = include('DATABASE/show.php');
include("config.php");



if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = "SELECT * FROM products WHERE product_name LIKE '{$input}%' OR product_type LIKE '{$input}%' OR quantity LIKE '{$input}%' OR img LIKE '{$input}%' OR created_by LIKE '{$input}%' OR created_at LIKE '{$input}%' OR updated_at LIKE '{$input}%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th >quantity</th>
                    <th width="20%">MANUFACTURE & EXPIRATION DATE</th>
                    <th>Create By</th>
                    <th width="20%">Created By & Updated At </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $product_name = $row['product_name'];
                $product_type = $row['product_type'];
                $quantity = $row['quantity'];
                $manufacture_date = $row['manufacture_date'];
                $expiration_date = $row['expiration_date'];
                $img = $row['img'];
                $created_by = $row['created_by'];
                $created_at = $row['created_at'];
                $updated_at = $row['updated_at'];
                $unit = $row['unit'];
               $cssClass = ($row['quantity'] <= 2) ? 'low-stock' : '';

               $currentDate = date('Y-m-d');
                    $daysUntilExpiration = floor((strtotime($expiration_date) - strtotime($currentDate)) / (60 * 60 * 24));

                    // Determine CSS class for highlighting
                    $css = '';
                    if ($daysUntilExpiration <= 30 && $daysUntilExpiration >= 0) {
                        $css = 'expiring';
                    } elseif ($daysUntilExpiration < 0) {
                        $css = 'expired';
                    }
            ?>
                <tr>
                    <td class="<?=$css?>"><?= $index + 1 ?></td>
                    <td class="lastName <?=$css?>"><?= $product_name ?> </td>
                    <td class="lastName <?=$css?>"><?= $product_type ?> </td>
                    <td class="lastName <?=$cssClass?>"><?= $quantity ?><?= $unit ?> </td>
                    <td class="<?=$css?>"><span id="mfg1">MANUFACTURE @: <span id="mfg2"><?= date('M d, Y', strtotime( $manufacture_date))?></span></span><span id="exp1"> EXPIRATION @: <span id="exp2"><?= date('M d, Y', strtotime( $expiration_date))?></span></td> 
                    <td class="<?=$css?>">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
                        $stmt->execute([$created_by]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                        echo $created_by_name;
                        ?>
                    </td>
                    <td class="<?=$css?>"><span id="date">CREATED BY: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime($created_at))?></span></span><span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($updated_at))?></span></span></td>
                    <td class="<?=$css?>">
                        <a href="" class="updateProduct" data-pid="<?= $id ?>"><i class="fa fa-pencil"></i>EDIT</a>
                        <a href="" class="deleteProduct" data-name="<?= $product_name ?>" data-pid="<?= $id ?>"><i class="fa fa-trash"></i>DELETE</a>
                    </td>
                </tr>
            <?php    
            }
            ?>
            </tbody>
        </table>
        <p class="userCount"><?= mysqli_num_rows($result) ?> products</p>
        <?php
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}
?>
