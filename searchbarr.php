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
                    <th width="2%">#</th>
                    <th  width="8%">Image</th>
                    <th  width="13%">Product Name</th>
                    <th width="10%">Product Type</th>
                    <th width="10%">quantity</th>
                    <th width="20%">MANUFACTURE & EXPIRATION DATE</th>
                    <th width="12%">Create By</th>
                    <th width="20%">Created By & Updated At </th>
                    <th width="8%">Action</th>
                </tr>
            </thead>
            <tbody id="showdata">
            <?php
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                 $id = $row['id'];
                $product_name = $row['product_name'];
                $product_type = $row['product_type'];
                $quantity = $row['quantity'];
                $manufacture_date = $row['manufacture_date'];
                $img = $row['img'];
                $expiration_date = $row['expiration_date'];
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
                    <td class="firstName <?=$css?>">
                        <img class="productImages" src="uploads/products/<?= $img ?>" alt="" /><a href="" class="updateProductpic" data-pid="<?= $id ?>"><i class="fa fa-image"></i>EDIT</a>
                    </td>
                    <td class="lastName <?=$css?>"><?= $product_name ?> </td>
                    <td class="lastName <?=$css?>"><?= $product_type ?> </td>
                    <td class="<?=$cssClass?> lastName"><?= $quantity ?><?= $unit ?> </td>
                    <td class="lastName <?=$css?>"><span id="mfg1">MANUFACTURE @: <span id="mfg2"><?= date('M d, Y', strtotime( $manufacture_date))?></span></span><span id="exp1"> EXPIRATION @: <span id="exp2"><?= date('M d, Y', strtotime( $expiration_date))?></span></td> 
                    <td class="lastName <?=$css?>">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
                        $stmt->execute([$created_by]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                        echo $created_by_name;
                        ?>
                    </td>
                    <td class="lastName <?=$css?>"><span id="date">CREATED BY: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime($created_at))?></span></span><span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($updated_at))?></span></span></td>
                    <td class="lastName <?=$css?>">
                        <a href="" class="updateProduct" data-pid="<?= $id ?>"><i class="fa fa-pencil"></i>EDIT</a>
                        <a href="" class="deleteProduct" data-name="<?= $product_name ?>" data-pid="<?= $id ?>"><i class="fa fa-trash"></i>DELETE</a>
                    </td>
                </tr>
            <?php
                $index++;
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
<script src="js/expiration.js"></script>
