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
                    <h1 class="h3 mb-2 text-gray-800">Reviews</h1>
                    <p class="mb-4">List of product reviews submitted by users.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                require_once __DIR__ . '/../config/db.php';
                                require_once __DIR__ . '/../helpers/db_queries.php';
                                $reviews = selectQuery($conn, "SELECT r.review_id, r.rating, r.review_comment, r.created_at, u.name AS user_name, b.book_name FROM reviews r LEFT JOIN users u ON r.user_id = u.user_id LEFT JOIN books b ON r.book_id = b.book_id ORDER BY r.created_at DESC");
                                ?>
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Book</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $c=1; while ($rev = $reviews->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $c++; ?></td>
                                            <td><?= htmlspecialchars($rev['user_name']) ?></td>
                                            <td><?= htmlspecialchars($rev['book_name']) ?></td>
                                            <td><?= htmlspecialchars($rev['rating']) ?></td>
                                            <td><?= htmlspecialchars($rev['review_comment']) ?></td>
                                            <td><?= htmlspecialchars($rev['created_at']) ?></td>
                                            <td><a href="#" class="text-dark">Delete</a></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                                       
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