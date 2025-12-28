<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'includes/header.php'; ?>
                <div class="container-fluid">
                    <h1 class="h1 mb-4 text-gray-900">Edit Product</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? intval($_GET['id']) : '' ?>">

                                <?php
                                require_once __DIR__ . '/../config/db.php';
                                require_once __DIR__ . '/../helpers/db_queries.php';
                                $publishers = selectQuery($conn, "SELECT publisher_id, publisher_name FROM publishers ORDER BY publisher_name");
                                $categories = selectQuery($conn, "SELECT category_id, name FROM categories ORDER BY name");
                                $authors = selectQuery($conn, "SELECT author_id, author_name FROM authors ORDER BY author_name");
                                ?>

                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control form-control-user" name="isbn" value="" placeholder="Enter ISBN">
                                </div>

                                <div class="form-group">
                                    <label>Book name</label>
                                    <input type="text" class="form-control form-control-user" name="book_name" value="" placeholder="Enter book name">
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control form-control-user" name="price" value="" placeholder="Enter price">
                                </div>

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control form-control-user" name="quantity" value="" placeholder="Enter quantity">
                                </div>

                                <div class="form-group">
                                    <label>Publisher</label>
                                    <select class="form-control" name="publisher_id">
                                        <?php while($pub = $publishers->fetch_assoc()): ?>
                                            <option value="<?= $pub['publisher_id'] ?>"><?= htmlspecialchars($pub['publisher_name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Authors</label>
                                    <select class="form-control" name="authors[]" multiple>
                                        <?php while($a = $authors->fetch_assoc()): ?>
                                            <option value="<?= $a['author_id'] ?>"><?= htmlspecialchars($a['author_name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control" name="categories[]" multiple>
                                        <?php while($c = $categories->fetch_assoc()): ?>
                                            <option value="<?= $c['category_id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" name="book_description" placeholder="Enter book description"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Now</button>
                                <a href="products.php" class="btn btn-link ml-3">&larr; Go Back</a>

                            </form>
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