<?php
require_once 'includes/check_login.php';
require_once 'assets/database/Database.php';

$db = Database::getInstance();
$categories = $db->query("SELECT category_id, name FROM categories");
$errors =[];

if (isset($_POST['submit'])) {
$name = htmlspecialchars(trim($_POST['name']));
if(empty($name))
    $errors [] = "الرجاء ادخال اسم القسم";
foreach ($categories as $cat ) {
    if ($cat['name'] == $name){
    $errors []= "القسم المدخل موجود مسبقا";
    break;
    }
}

if(empty($errors)){
    try {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $db->query($sql, [$name]);
        header("Location: add_category.php?status=success");
        // exit();
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
    <title>Add Category</title>
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
                    <h1 class="h1 mb-4 text-gray-900">Add category</h1>
                    <div class="card shadow mb-4" style="max-width:720px;">
                        <div class="card-body">
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                                <div class="alert alert-success">تمت إضافة الكتاب وربط جميع البيانات بنجاح!</div>
                                <?php endif; ?>

                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors as $error) echo "<div>" . htmlspecialchars($error) ."</div>"; ?>
                                    </div>
                            <?php endif; ?>
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter category name" required>
                                </div>

                                <button type="submit" class="btn btn-success" name="submit">ADD</button>
                                <a href="categories.php" class="btn btn-link ml-3">&larr; Go Back</a>
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