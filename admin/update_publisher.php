<?php
require_once 'includes/check_login.php';
?>
<?php
require_once 'assets/database/Database.php';

$db = Database::getInstance();
$errors = [];
$publisher_name = '';
$publisher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Load existing publisher
if ($publisher_id) {
    $stmt = $db->query("SELECT publisher_id, publisher_name FROM publishers WHERE publisher_id = ?", [$publisher_id]);
    $pub = $stmt->fetch();
    if ($pub) {
        $publisher_name = $pub['publisher_name'];
    } else {
        // invalid id
        header('Location: publishers.php');
        exit();
    }
} else {
    header('Location: publishers.php');
    exit();
}

if (isset($_POST['submit'])) {
    $publisher_name = trim($_POST['publisher_name'] ?? '');
    $publisher_name = htmlspecialchars($publisher_name);

    if ($publisher_name === '') {
        $errors[] = 'الرجاء إدخال اسم الناشر';
    } else {
        // duplicate check excluding current id
        $stmt = $db->query("SELECT publisher_id FROM publishers WHERE LOWER(publisher_name) = LOWER(?) AND publisher_id != ?", [$publisher_name, $publisher_id]);
        $exists = $stmt->fetch();
        if ($exists) {
            $errors[] = 'الناشر موجود مسبقاً';
        }
    }

    if (empty($errors)) {
        try {
            $db->query("UPDATE publishers SET publisher_name = ? WHERE publisher_id = ?", [$publisher_name, $publisher_id]);
            header("Location: update_publisher.php?id={$publisher_id}&status=success");
            exit();
        } catch (Exception $e) {
            error_log('Publisher update failed: ' . $e->getMessage());
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
    <title>Edit Publisher</title>
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

                    <h1 class="h1 mb-4 text-gray-900">Edit Publisher</h1>

                    <div class="card shadow mb-4" style="max-width:720px;">
                        <div class="card-body">

                            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                                <div class="alert alert-success">تم تحديث الناشر بنجاح!</div>
                            <?php endif; ?>

                            <?php if (!empty($errors) && is_array($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <div><?= htmlspecialchars($error) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= $publisher_id ?>">

                                <div class="form-group">
                                    <label>Publisher Name</label>
                                    <input type="text" class="form-control" name="publisher_name" value="<?= htmlspecialchars($publisher_name) ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
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
