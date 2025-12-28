<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Authors - Admin</title>

    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <?php include 'includes/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include 'includes/header.php'; ?>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h1 mb-0 text-gray-900">Authors</h1>
                        <a href="add_author.php" class="btn btn-success shadow-sm"><i class="fas fa-plus mr-1"></i> Add New Author</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php
                            require_once __DIR__ . '/../config/db.php';
                            require_once __DIR__ . '/../helpers/db_queries.php';
                            $authors = selectQuery($conn, "SELECT author_id, author_name, author_description FROM authors ORDER BY author_id DESC");
                            ?>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($a = $authors->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($a['author_id']) ?></td>
                                            <td><?= htmlspecialchars($a['author_name']) ?></td>
                                            <td><?= htmlspecialchars(substr($a['author_description'],0,120)) ?></td>
                                            <td><a href="#" class="text-primary"><i class="fas fa-edit fa-lg"></i></a></td>
                                            <td><a href="#" class="text-dark"><i class="fas fa-trash-alt fa-lg"></i></a></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <?php include 'includes/footer.php'; ?>

            </div>
        </div>

    </div>

    <?php include 'includes/scripts.php'; ?>

</body>

</html>