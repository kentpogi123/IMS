<?php
 session_start();
  if(!isset($_SESSION['user'])) header('location:index.php');
  $_SESSION['table'] = 'tablewares';
   $tablewares = include('DATABASE/show.php');
include("config.php");



if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = "SELECT * FROM tablewares WHERE PC_tableware LIKE '{$input}%' OR tableware_type LIKE '{$input}%' OR quantity LIKE '{$input}%' OR tableware_pic LIKE '{$input}%'OR unit LIKE '{$input}%' OR g_condition LIKE '{$input}%' OR missing LIKE '{$input}%' OR damage LIKE '{$input}%' OR created_by LIKE '{$input}%' OR created_at LIKE '{$input}%' OR updated_at LIKE '{$input}%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <thead>
                <tr>
                    <th width="2%">#</th>
                    <th  width="8%">Image</th>
                    <th  width="13%">EQUIPMENT Name</th>
                    <th width="10%">EQUIPMENT Type</th>
                    <th width="10%">quantity</th>
                    <th>GOOD CONDITION</th>
                    <th>MISSING</th>
                    <th>DAMAGE</th>
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
                $PC_tableware = $row['PC_tableware'];
                $tableware_type = $row['tableware_type'];
                $quantity = $row['quantity'];
                $tableware_pic = $row['tableware_pic'];
                $unit = $row['unit'];
                $g_condition = $row['g_condition'];
                $missing = $row['missing'];
                $damage = $row['damage'];
                $created_by = $row['created_by'];
                $created_at = $row['created_at'];
                $updated_at = $row['updated_at'];
                $cssClass = ($row['quantity'] <= 30) ? 'low-stock' : '';
                $gnote = ($row['g_condition'] <=15) ? 'gnote' : '';
                $alert = ($row['missing'] >= 5) ? 'missing-alert' : '';
                $warning = ($row['damage'] >= 5) ? 'damage-alert' : '';
            
            ?>
                <tr>
                    <td class=""><?= $index + 1 ?></td>
                    <td class="firstName ">
                        <img class="productImages" src="tablewarepic/pics/<?= $tableware_pic ?>" alt="" /><a href="" class="updateTablewarepic" data-tid="<?= $id ?>"><i class="fa fa-image"></i>EDIT</a>
                    </td>
                    <td class="lastName "><?= $PC_tableware ?> </td>
                    <td class="lastName "><?= $tableware_type ?> </td>
                    <td class="lastName <?= $cssClass ?>"><?= $quantity ?><?= $unit ?> </td>
                    <td class="lastName <?= $gnote ?>"><?= $g_condition ?><?= $unit ?> </td>
                    <td class="lastName <?= $alert ?>"><?= $missing ?><?= $unit ?> </td>
                    <td class="lastName <?= $warning ?>"><?= $damage ?><?= $unit ?> </td>
                    <td class="lastName ">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
                        $stmt->execute([$created_by]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                        echo $created_by_name;
                        ?>
                    </td>
                    <td class="lastName "><span id="date">CREATED BY: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime($created_at))?></span></span><span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($updated_at))?></span></span></td>
                    <td class="lastName ">
                        <a href="" class="updateTableware" data-tid="<?= $id ?>"><i class="fa fa-pencil"></i>EDIT</a>
                        <a href="" class="deleteTableware" data-pcname="<?= $product_name ?>" data-tid="<?= $id ?>"><i class="fa fa-trash"></i>DELETE</a>
                    </td>
                </tr>
            <?php
                $index++;
            }
            ?>
            </tbody>
        </table>
        <p class="userCount"><?= mysqli_num_rows($result) ?> tablewares</p>
        <?php
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}
?>
<script src="js/expiration.js"></script>
