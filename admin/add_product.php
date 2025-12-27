<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add product</title>
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
                    <h1 class="h1 mb-4 text-gray-900">Add product</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="#" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>product name</label>
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="enter product name">
                                </div>

                                <div class="form-group">
                                    <label>product price</label>
                                    <input type="text" class="form-control form-control-user" name="price" placeholder="enter product price">
                                </div>

                                <div class="form-group">
                                    <label>product image</label>
                                    <input type="file" class="form-control-file" name="image">
                                </div>

                                <div class="form-group">
                                    <label>product details</label>
                                    <textarea class="form-control" rows="4" name="description" placeholder="enter product details"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>category</label>
                                    <select class="form-control" name="category_id">
                                        <option value="1">1 - RINGS</option>
                                        <option value="2">2 - NECKLACES</option>
                                        <option value="3">3 - EARRINGS</option>
                                        <option value="4">4 - BRACELETS</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success">add product</button>
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