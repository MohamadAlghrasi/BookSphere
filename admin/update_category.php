<?php
require_once 'includes/check_login.php';
?>
<?php
require_once 'assets/database/Database.php';

$db = Database::getInstance();

if(isset($_POST['submit'])) {
    $errors = [];
    $name = htmlspecialchars(trim($_POST['name']));
    $category_id =  $_GET['id'];

if (empty($name)) {
        $errors[] = "اسم القسم مطلوب.";
    } else {
        $sql_check = "SELECT name FROM categories WHERE name = ? ";
        $existing_category = $db->query($sql_check, [$name])->fetch();

        if ($existing_category) {
            $errors[] = "خطأ: اسم القسم هذا موجود مسبقاً، يرجى اختيار اسم آخر.";
        }
    }

    // 3. إذا لم توجد أخطاء، يتم التحديث
    if (empty($errors)) {

        try {
            $sql_update = "UPDATE categories SET name = ? WHERE category_id = ?";
            $db->query($sql_update, [$name, $category_id]);

            header("Location: categories.php?status=updated");
            exit();
            } catch (Exception $e) {
            $errors[] = "حدث خطأ أثناء التحديث: " . $e->getMessage();
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
    <title>Edit Category</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'includes/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'includes/header.php'; ?>
                <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
                                <div class="alert alert-success">تمت إضافة الكتاب وربط جميع البيانات بنجاح!</div>
                            <?php endif; ?>

                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error) echo "<div>$error</div>"; ?>
                                </div>
                            <?php endif; ?>
                <div class="container-fluid">

                    <h1 class="h1 mb-4 text-gray-900">Edit Category</h1>

                    <div class="card shadow mb-4" style="max-width:720px;">
                        <div class="card-body">
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" value="" required>
                                </div>

                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
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