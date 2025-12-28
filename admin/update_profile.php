<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Profile</title>
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

                    <h1 class="h1 mb-4 text-gray-900">Edit Profile</h1>

                    <div class="card shadow mb-4" style="max-width:720px;">
                        <div class="card-body">
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control form-control-user" name="name" value="" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control form-control-user" name="email" value="" required>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control form-control-user" name="phone" value="">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control form-control-user" name="address" value="">
                                </div>

                                <hr />

                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control form-control-user" name="current_password" value="">
                                </div>

                                <div class="form-group">
                                    <label>Enter New Password</label>
                                    <input type="password" class="form-control form-control-user" name="new_password" placeholder="Enter New Password">
                                </div>

                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control form-control-user" name="confirm_password" placeholder="Confirm New Password">
                                </div>

                                <button type="submit" class="btn btn-success">Update Now</button>
                                <a href="index.php" class="btn btn-link ml-3">&larr; Go Back</a>
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