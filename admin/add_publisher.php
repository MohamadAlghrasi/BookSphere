<?php
require_once 'includes/check_login.php';
require_once 'assets/database/Database.php';

$db = Database::getInstance();
$errors = [];
$publisher_name = '';

if (isset($_POST['submit'])) {
    $publisher_name = trim($_POST['publisher_name'] ?? '');
    $publisher_name = htmlspecialchars($publisher_name);

    if ($publisher_name === '') {
        $errors[] = 'الرجاء إدخال اسم الناشر';
    } else {
        // case-insensitive duplicate check
        $stmt = $db->query("SELECT publisher_id FROM publishers WHERE LOWER(publisher_name) = LOWER(?)", [$publisher_name]);
        $exists = $stmt->fetch();
        if ($exists) {
            $errors[] = 'الناشر موجود مسبقاً';
        }
    }

    if (empty($errors)) {
        try {
            $db->query("INSERT INTO publishers (publisher_name) VALUES (?)", [$publisher_name]);
            header('Location: add_publisher.php?status=success');
            exit();
        } catch (Exception $e) {
            error_log('Publisher insert failed: ' . $e->getMessage());
            $errors[] = 'حدث خطأ أثناء الحفظ، الرجاء المحاولة لاحقاً.';
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
    <title>Add Publisher</title>
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

                    <h1 class="h1 mb-4 text-gray-900">Add Publisher</h1>

                    <div class="card shadow mb-4" style="max-width:720px;">
                        <div class="card-body">
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label>Publisher Name</label>
                                    <input type="text" class="form-control" name="publisher_name" placeholder="Enter publisher name" required>
                                </div>

                                <button type="submit" class="btn btn-success">ADD</button>
                                <a href="publishers.php" class="btn btn-link ml-3">&larr; Go Back</a>
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