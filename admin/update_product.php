<?php
require_once 'assets/database/Database.php';


$db = Database::getInstance();
$publishers = $db->query("SELECT publisher_id, publisher_name FROM publishers");
$categories = $db->query("SELECT category_id, name FROM categories");
$authors    = $db->query("SELECT author_id, author_name FROM authors");
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
}
if (isset($_POST['submit'])) {

    $errors = [];

    // Sanitization 
    $isbn         = htmlspecialchars(trim($_POST['isbn']));
    $publisher_id = filter_var($_POST['publisher_id'], FILTER_SANITIZE_NUMBER_INT);
    $category_id  = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $author_id    = filter_var($_POST['author_id'], FILTER_SANITIZE_NUMBER_INT);
    $book_name    = htmlspecialchars(trim($_POST['book_name']));
    $description  = htmlspecialchars(trim($_POST['book_description']));
    $stock        = filter_var($_POST['stock'], FILTER_SANITIZE_NUMBER_INT);
    $price        = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $selected_authors = isset($_POST['author_id']) ? (array)$_POST['author_id'] : [];
    $selected_categories = isset($_POST['category_id']) ? (array)$_POST['category_id'] : [];
    //Validation
    if (empty($isbn) || empty($publisher_id) || empty($category_id) || empty($book_name) || empty($price) || empty($author_id)) {
        $errors[] = "جميع الحقول المميزة بنجمة مطلوبة.";
    }
    $image_path = "";
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $upload_dir = "assets/img/";
        $image_name = time() . "_" . $_FILES['book_image']['name'];
        $image_path = $upload_dir . $image_name;
        move_uploaded_file($_FILES['book_image']['tmp_name'], $image_path);
    }
    // $check_category = $db->query("SELECT category_id FROM categories WHERE category_id = ?", [$category_id]);
    // if (empty($check_category)) {
    //     $errors[] = "القسم المختار غير موجود في النظام.";
    // }
    // $check_publisher = $db->query("SELECT publisher_id FROM publishers WHERE publisher_id = ?", [$publisher_id]);
    // if (empty($check_publisher)) {
    //     $errors[] = "الناشر المختار غير موجود في النظام.";
    // }

    if (empty($errors)) {
        try {
            $sql = "UPDATE  books SET isbn= ?, publisher_id= ?, book_name= ?, book_description= ?, stock= ?, price= ? WHERE book_id = $book_id";
            $db->query($sql, [$isbn, $publisher_id, $book_name, $description, $stock, $price]);
            // $new_book_id = $db->lastInsertId();
            // $new_book_id = $db->query("SELECT book_id FROM books WHERE isbn = ?", [$isbn]);
            $db->query("DELETE FROM book_author WHERE book_id = ?", [$book_id]);
            foreach ($selected_authors as $a_id) {
                $db->query("INSERT INTO book_author (book_id, author_id) VALUES (?, ?)", [$book_id, $a_id]);
            }

            $db->query("DELETE FROM book_category WHERE book_id = ?", [$book_id]);
            foreach ($selected_categories as $c_id) {
                $db->query("INSERT INTO book_category (book_id, category_id) VALUES (?, ?)", [$book_id, $c_id]);
            }
            
            if ($image_path) {
                $db->query("UPDATE  images SET  image_path=?, is_main =1 WHERE book_id= $book_id", [ $image_path]);
            }
            $success = "تم إضافة الكتاب الجديد بنجاح إلى المتجر!";
            header("Location: update_product.php?id=$book_id&status=success");
            exit();
        } catch (Exception $e) {
            $errors[] = "حدث خطأ أثناء الحفظ: " ;// . $e->getMessage()
           
        }
    }
}


?>

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
                    <h1 class="h1 mb-4 text-gray-900">Update Book</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                                <div class="alert alert-success">تمت إضافة الكتاب وربط جميع البيانات بنجاح!</div>
                            <?php endif; ?>

                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error) echo "<div>$error</div>"; ?>
                                </div>
                            <?php endif; ?>
                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Book isbn</label>
                                    <input type="text" class="form-control form-control-user" name="isbn" placeholder="enter Book isbn" required>
                                </div>
                                <div class="form-group">
                                    <label>Book name</label>
                                    <input type="text" class="form-control form-control-user" name="book_name" placeholder="enter Book name" required>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" class="form-select form-select-user" required>
                                        <option value="">-- Select Category --</option> <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['category_id'] ?>"><?= $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Author </label>
                                    <select name="author_id" class="form-select form-select-user" required><!--  -->
                                        <option value="">-- Select Author --</option>
                                        <?php foreach($authors as $auth): ?>
                                            <option value="<?= $auth['author_id'] ?>"><?= $auth['author_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Publisher </label>
                                    <select name="publisher_id" class="form-select form-select-user">
                                        <option value="">-- select publisher --</option>
                                        <?php foreach ($publishers as $pub): ?>
                                            <option value="<?= $pub['publisher_id'] ?>" <?= (isset($_POST['publisher_id']) && $_POST['publisher_id'] == $pub['publisher_id']) ? 'selected' : '' ?>>
                                                <?= $pub['publisher_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Book Image</label>
                                    <input type="file" name="book_image" class="form-control form-control-user">
                                </div>
                                <div class="form-group">
                                    <label>Book Description</label>
                                    <input type="text" class="form-control form-control-user" name="book_description" placeholder="enter Book Description">
                                </div>
                                <div class="form-group">
                                    <label>Book Stock</label>
                                    <input type="text" class="form-control form-control-user" name="stock" placeholder="enter Book Stock">
                                </div>
                                <div class="form-group">
                                    <label>Book price</label>
                                    <input type="text" class="form-control form-control-user" name="price" placeholder="enter Book price">
                                </div>
                                <button type="submit" class="btn btn-success" name="submit">add product</button>
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