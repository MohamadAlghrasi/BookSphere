<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar / Header -->
                <?php include 'includes/header.php'; ?>
                <!-- End of Topbar / Header -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h1 mb-4 text-gray-900">Orders</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                require_once __DIR__ . '/../config/db.php';
                                require_once __DIR__ . '/../helpers/db_queries.php';
                                $orders = selectQuery($conn, "SELECT o.order_id, o.created_at, u.name, u.email, u.phone, u.address FROM orders o LEFT JOIN users u ON o.user_id = u.user_id ORDER BY o.order_id DESC");
                                ?>
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $c=1; while ($order = $orders->fetch_assoc()): // $orders declared above 
                                             ?>
                                        <tr>
                                            <td><?=$c++?></td>
                                            <td><?= htmlspecialchars($order['name']) ?> </td>
                                            <td><?= htmlspecialchars(string: $order['email']) ?></td>
                                            <td><?= htmlspecialchars(string: $order['phone']) ?></td>
                                            <td><?= htmlspecialchars(string: $order['address']) ?></td>
                                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

                       <!-- Footer -->
                <?php include 'includes/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
                <!-- scripts -->
                <?php include 'includes/scripts.php'; ?>
                <!-- End of scripts -->

</body>

</html>