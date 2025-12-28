<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] ?? 'User' : 'Guest';

// Get books
$sqlBooks = "SELECT b.book_id, b.book_name, b.price, b.stock, 
             a.author_name, c.name as category_name, i.image_path,
             COALESCE(AVG(r.rating), 0) as avg_rating,
             COUNT(r.review_id) as review_count
             FROM Books b
             LEFT JOIN Book_Author ba ON b.book_id = ba.book_id 
             LEFT JOIN Authors a ON a.author_id = ba.author_id
             LEFT JOIN Book_Category bc ON b.book_id = bc.book_id
             LEFT JOIN Categories c ON c.category_id = bc.category_id
             LEFT JOIN Images i ON b.book_id = i.book_id AND i.is_main = 1
             LEFT JOIN Reviews r ON b.book_id = r.book_id
             GROUP BY b.book_id
             ORDER BY b.book_id DESC
             LIMIT 8";

$resultBooks = selectQuery($conn, $sqlBooks);

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>BookSphere - Your Online Bookstore</title>
    <meta name="description" content="Discover your next favorite book at BookSphere" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12 ms-auto">
                        <div class="top-end d-flex justify-content-end align-items-center">
                            <div class="user me-3">
                                <i class="lni lni-user"></i>
                                Hello
                            </div>
                            <ul class="user-login d-flex mb-0">
                                <li class="me-3">
                                    <a href="login.php">Sign In</a>
                                </li>
                                <li>
                                    <a href="register.php">Register</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <!-- Start Hero Slider Area -->
    <section class="hero-area hero-area-full">
        <div class="container-fluid px-0">
            <div class="slider-head">
                <div class="hero-slider">

                    <!-- Slide 1 -->
                    <div class="single-slider" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=600&fit=crop') center/cover no-repeat; min-height: 600px;">
                        <div class="content container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 text-center">
                                    <h2 class="text-white" style="font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                        Discover Your Next <span style="color: #ffd700;">Favorite Book</span>
                                    </h2>
                                    <p class="text-white mb-4" style="font-size: 1.3rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                                        Browse bestselling titles, new releases, and curated picks
                                    </p>
                                    <div class="button">
                                        <a href="<?= $isLoggedIn ? 'shop.php' : 'login.php' ?>" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
                                            <i class="lni lni-book me-2"></i> Shop Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="single-slider" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=1920&h=600&fit=crop') center/cover no-repeat; min-height: 600px;">
                        <div class="content container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 text-center">
                                    <h2 class="text-white" style="font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                        New Arrivals <span style="color: #ffd700;">Every Week</span>
                                    </h2>
                                    <p class="text-white mb-4" style="font-size: 1.3rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                                        Fresh books added regularly — don't miss out on the latest releases
                                    </p>
                                    <div class="button">
                                        <a href="<?= $isLoggedIn ? 'shop.php' : 'login.php' ?>" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
                                            <i class="lni lni-star me-2"></i> Explore Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="single-slider" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1920&h=600&fit=crop') center/cover no-repeat; min-height: 600px;">
                        <div class="content container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 text-center">
                                    <h2 class="text-white" style="font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                        <span style="color: #ffd700;">Free Shipping</span> on All Orders
                                    </h2>
                                    <p class="text-white mb-4" style="font-size: 1.3rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                                        Get your favorite books delivered to your doorstep at no extra cost
                                    </p>
                                    <div class="button">
                                        <a href="<?= $isLoggedIn ? 'shop.php' : 'login.php' ?>" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
                                            <i class="lni lni-delivery me-2"></i> Start Shopping
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center p-4">
                        <div class="mb-3">
                            <i class="lni lni-delivery" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                        <h5>Free Shipping</h5>
                        <p class="text-muted mb-0">On all orders</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-center p-4">
                        <div class="mb-3">
                            <i class="lni lni-credit-cards" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                        <h5>Secure Payment</h5>
                        <p class="text-muted mb-0">100% secure transactions</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-center p-4">
                        <div class="mb-3">
                            <i class="lni lni-reload" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                        <h5>Easy Returns</h5>
                        <p class="text-muted mb-0">30-day return policy</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-center p-4">
                        <div class="mb-3">
                            <i class="lni lni-support" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                        <h5>24/7 Support</h5>
                        <p class="text-muted mb-0">Always here to help</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Trending Books Area -->
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 style="font-size: 2.5rem; font-weight: 700;">Featured Books</h2>
                        <p class="text-muted">Discover our handpicked selection of bestselling and trending books</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php
                if ($resultBooks->num_rows > 0) {
                    while ($book = $resultBooks->fetch_assoc()) {
                        $avgRating = round($book['avg_rating']);
                        $reviewCount = $book['review_count'];
                ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="card shadow-sm h-100 border-0" style="transition: transform 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='translateY(-10px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <div class="card-body p-3">
                                    <!-- Book Image -->
                                    <div class="position-relative mb-3" style="height: 250px; overflow: hidden; border-radius: 10px;">
                                        <?php if (!empty($book['image_path'])): ?>
                                            <img src="<?= htmlspecialchars($book['image_path']) ?>"
                                                alt="<?= htmlspecialchars($book['book_name']) ?>"
                                                class="w-100 h-100"
                                                style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <i class="lni lni-book" style="font-size: 5rem; color: white; opacity: 0.5;"></i>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Stock Badge -->
                                        <?php if ($book['stock'] > 0): ?>
                                            <span class="badge bg-success position-absolute" style="top: 10px; right: 10px;">
                                                In Stock
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px;">
                                                Out of Stock
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Category -->
                                    <span class="badge bg-light text-dark mb-2">
                                        <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized') ?>
                                    </span>

                                    <!-- Book Title -->
                                    <h6 class="mb-1" style="height: 40px; overflow: hidden;">
                                        <a href="product.php?book_id=<?= $book['book_id'] ?>"
                                            class="text-dark text-decoration-none">
                                            <?= htmlspecialchars($book['book_name']) ?>
                                        </a>
                                    </h6>

                                    <!-- Author -->
                                    <small class="text-muted d-block mb-2">
                                        by <?= htmlspecialchars($book['author_name'] ?? 'Unknown') ?>
                                    </small>

                                    <!-- Rating -->
                                    <div class="mb-2">
                                        <?php for ($i = 0; $i < $avgRating; $i++): ?>
                                            <i class="lni lni-star-filled text-warning"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $avgRating; $i < 5; $i++): ?>
                                            <i class="lni lni-star text-warning"></i>
                                        <?php endfor; ?>
                                        <small class="text-muted">(<?= $reviewCount ?>)</small>
                                    </div>

                                    <!-- Price -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0 text-primary" style="font-weight: 700;">
                                            $<?= number_format($book['price'], 2) ?>
                                        </h5>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex gap-2">
                                        <a href="<?= $isLoggedIn ? 'product.php?book_id=' . $book["book_id"] : 'login.php' ?>"
                                            class="btn btn-outline-primary btn-sm w-100">
                                            <i class="lni lni-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12"><p class="text-center text-muted">No books available at the moment.</p></div>';
                }
                ?>
            </div>

            <!-- View All Button -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="shop.php" class="btn btn-primary btn-lg px-5" style="border-radius: 50px;">
                        <i class="lni lni-book me-2"></i> View All Books
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <h3 class="text-white mb-2" style="font-weight: 700;">
                        Join Our Book-Loving Community
                    </h3>
                    <p class="text-white mb-0" style="opacity: 0.9;">
                        Get exclusive deals, new release alerts, and personalized recommendations
                    </p>
                </div>
                <div class="col-lg-4 col-md-5 text-end">
                    <a href="register.php" class="btn btn-light btn-lg px-5" style="border-radius: 50px;">
                        Sign Up Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Footer Area -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="footer-logo">
                                <h3 class="text-white mb-3">📚 BookSphere</h3>
                                <p class="text-white">Your trusted online bookstore for discovering amazing reads.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>Quick Links</h3>
                                <ul>
                                    <li><a href="shop.php">Browse Books</a></li>
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-footer f-contact">
                                <h3>Contact Us</h3>
                                <p class="phone">Phone: +1 (900) 33 169 7720</p>
                                <p class="mail">
                                    <a href="mailto:support@booksphere.com">support@booksphere.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <div class="copyright">
                                <p>© 2025 BookSphere. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript">
        //========= Hero Slider 
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            autoplayTimeout: 5000,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: true,
            navPosition: 'bottom',
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            speed: 800
        });
    </script>
</body>

</html>