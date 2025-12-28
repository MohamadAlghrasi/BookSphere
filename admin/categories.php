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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h1 mb-0 text-gray-900">Category</h1>
                        <a href="add_category.php" class="btn btn-success shadow-sm"><i class="fas fa-plus mr-1"></i> Add New Category</a>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/db_queries.php';
$categories = selectQuery($conn, "SELECT category_id, name FROM categories ORDER BY category_id DESC");
?>
                                    <tbody>
                                        <?php while ($cat = $categories->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($cat['category_id']) ?></td>
                                            <td><?= htmlspecialchars($cat['name']) ?></td>
                                            <td><a href="update_category.php?id=<?= $cat['category_id'] ?>" class="text-primary"><i class="fas fa-edit fa-lg"></i></a></td>
                                            <td><a href="#" class="text-dark"><i class="fas fa-trash-alt fa-lg"></i></a></td>
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