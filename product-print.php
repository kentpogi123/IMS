<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (!isset($_SESSION['user'])) {
    header('location:index.php');
}
$_SESSION['table'] = 'products';
$products = include('DATABASE/show.php');
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php include('partials/app-header-scripts.php'); ?>
    <title>View Products - Inventory Management System</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php') ?>
            <div class="printcss">
                <span class="printsee"><a href="product-print-minimize.php"><i class="fa fa-image"></i>W/OPICTURES</a></span>
                <button onclick="printPage()">Print</button>
            </div>

            <div class="dashboard_content" id="printpdf">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-list"></i>List of Products</h1>
                            <div id="searchresult"></div>
                            <div class="section_content" id="popup">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="2%">#</th>
                                                <th width="8%">Image</th>
                                                <th width="13%">Product Name</th>
                                                <th width="10%">Product Type</th>
                                                <th width="10%">quantity</th>
                                                <th width="20%">MANUFACTURE & EXPIRATION DATE</th>
                                                <th width="12%">Create By</th>
                                                <th width="20%">Created By & Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showdata">
                                            <?php
                                            foreach ($products as $index => $product) {
                                                $cssClass = ($product['quantity'] <= 2) ? 'low-stock' : '';
                                            ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td class="firstName">
                                                        <img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="lastName"><?= $product['product_name'] ?></td>
                                                    <td class="lastName"><?= $product['product_type'] ?></td>
                                                    <td class="lastName <?= $cssClass ?>"><?= $product['quantity'] ?><?= $product['unit'] ?></td>
                                                    <td>
                                                        <span id="mfg1">MANUFACTURE @: <span id="mfg2"><?= date('M d, Y', strtotime($product['manufacture_date'])) ?></span></span>
                                                        <span id="exp1"> EXPIRATION @: <span id="exp2"><?= date('M d, Y', strtotime($product['expiration_date'])) ?></span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $pid = $product['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=$pid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                        echo $created_by_name;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span id="date">CREATED AT: <span id="date0"><?= date('M d, Y @ h:i:s A', strtotime($product["created_at"])) ?></span></span>
                                                        <span id="date1">UPDATED AT: <span id="date2"><?= date('M d, Y @ h:i:s A', strtotime($product["updated_at"])) ?></span></span>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($products) ?> products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/updateuserpic.js"></script>
    <script src="js/expiration.js"></script>
    <script>
       function printPage() {
            window.print();
        }
    </script>
</body>
</html>
