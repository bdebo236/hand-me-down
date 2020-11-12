<?php
    include 'dbconn.php';
    session_start();
    if(isset($_POST['email-submit'])) {
        $email = $_POST['email'];

        $sql = "INSERT into mailing_list (`email`) values('$email')";
        $conn->query($sql);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Hand Me Down</title>
        <!--Font awesome CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <!--Scroll reveal CDN-->
        <script src="https://unpkg.com/scrollreveal"></script>
        <link rel="stylesheet" href="../css/landing.css">
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
    </head>
    <body>
        <div class="pgtransition transition-1 is-active">
            <div class="loading">
                <div class="dot dot-1"></div>
                <div class="dot dot-2"></div>
                <div class="dot dot-3"></div>
            </div>
        </div>  <!--page transition-->
        <header>
            <div class="container">
                <nav class="nav">
                    <div class="menu-toggle">
                        <i class="fas fa-bars"></i>
                        <i class="fas fa-times"></i>
                    </div>
                    <a href="#" class="logo"><img src="../images/logo-01.png"></a>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="landing.php" class="nav-link active">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="search-book-html.php" class="nav-link">Search</a>
                        </li>
                        <li class="nav-item">
                            <?php  
                                if(isset($_SESSION['username'])) {
                                    echo '<a href="request-book.php" class="nav-link">Request</a>';
                                } else {
                                    echo '<a href="login.php" class="nav-link">Request</a>';
                                }
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php 
                                if(isset($_SESSION['username'])) {
                                    echo '<a href="sell-book.php" class="nav-link">Donate or Sell</a>';
                                } else {
                                    echo '<a href="login.php" class="nav-link">Donate or Sell</a>';
                                }
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php 
                                if(isset($_SESSION['username'])) {
                                    $username = $_SESSION['username'];
                                    $link = "profile.php?user=$username";
                                } else {
                                    $link = "login.php";
                                }
                            ?>
                            <a href= <?php echo $link;?> class="nav-link">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <?php
                                if(isset($_SESSION['username'])) {
                                    echo '<a href="logout.php" class="nav-link">Log Out</a>';
                                } else {
                                    echo '<a href="login.php" class="nav-link">Sign In</a>';
                                }
                            ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <!-- Header ends-->
        <section class="hero" id="hero" name="hero">
            <div class="container">
                <h2 class="sub-headline">
                    <span class="first-letter">W</span>elcome
                </h2>
                <h1 class="headline">Hand Me Down</h1>
                <div class="headline-description">
                    <div class="separator">
                        <div class="line line-left"></div>
                        <div class="asterisk"><i class="fas fa-asterisk"></i></div>
                        <div class="line line-right"></div>
                    </div>
                    <div class="single-animation">
                        <h5>Ready to be opened</h5>
                        <a href="search-book-html.php" class="btn cta-btn">Explore</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero ends -->
        <section class="discover-our-story">
            <div class="container">
                <div class="shop-info">
                    <div class="shop-description padding-right animate-left">
                        <div class="global-headline">
                            <h2 class="sub-headline">
                                <span class="first-letter">S</span>earch 
                            </h2>
                            <h1 class="headline headline-dark">and Request</h1>
                            <div class="asterisk"><i class="fas fa-asterisk"></i></div>
                        </div>
                        <p>
                        Search our huge collection for the book you want. You can search by Name of the Book, Author
                        Name. Just click on the name of the seller and start
                        chatting.
                        Can’t find it? Worry not! You can place a request on our site and connect with prospective sellers or
                        donors.
                        </p>
                        <a href="search-book-html.php" class="btn body-btn">Search Books</a>
                    </div>
                    <div class="shop-info-img animate-right">
                        <img src="../images/search-books.png" alt="Search Book">
                    </div>
                </div>
            </div>
        </section>
        <!--Search and Request story ends-->
        <section class="find-a-book between">
            <div class="container">
                <div class="global-headline">
                    <div class="animate-top">
                        <h2 class="sub-headline">
                            <span class="first-letter">F</span>ind
                        </h2>
                    </div>
                    <div class="animate-bottom">
                        <h1 class="headline">Your Story</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Find a book ends -->
        <section class="request-a-book">
            <div class="container">
                <div class="shop-info">
                    <div class="image-group padding-right animate-left">
                        <img src="../images/sell-book1.png" alt="Sell/Donate A Book1">
                        <img src="../images/sell-book2.png" alt="Sell/Donate A Book2">
                        <img src="../images/sell-book3.png" alt="Sell/Donate A Book3">
                        <img src="../images/sell-book4.png" alt="Sell/Donate A Book4">
                    </div>
                    <div class="shop-description animate-right">
                        <div class="global-headline">
                            <h2 class="sub-headline">
                                <span class="first-letter">D</span>onate or Sell 
                            </h2>
                            <h1 class="headline headline-dark">Your Book</h1>
                            <div class="asterisk"><i class="fas fa-asterisk"></i></div>
                        </div>
                        <p>
                        Moving house or just spring cleaning? You want to dispose of that carton full of old, well-loved
                        books, but not sell it as ‘raddi’? Welcome to Hand-me-downs! You can donate your books to our
                        database through our user-friendly site.
                        You can also list your books for sale and interested buyers can contact you through our portal.
                        </p>
                        <a href="sell-book.php" class="btn body-btn">Sell a Book</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Donate or Sell ends -->
        <section class="donate-or-sell between">
            <div class="container">
                <div class="global-headline">
                    <div class="animate-top">
                        <h2 class="sub-headline">
                            <span class="first-letter">A</span>lways Be A
                        </h2>
                    </div>
                    <div class="animate-bottom">
                        <h1 class="headline">little kinder than necessary</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Quote ends -->
        <section class="sign-up">
            <div class="container">
                <div class="shop-info">
                    <div class="shop-description padding-right animate-left">
                        <div class="global-headline">
                            <h2 class="sub-headline">
                                <span class="first-letter">S</span>ign Up
                            </h2>
                            <h1 class="headline headline-dark">and start chatting</h1>
                            <div class="asterisk"><i class="fas fa-asterisk"></i></div>
                        </div>
                        <p>
                        If you haven’t already, sign up and start chatting with other book lovers.
                        </p>
                        <a href="login.php" class="btn body-btn">Sign Up</a>
                    </div>
                    <div class="image-group">
                        <img class="animate-top" src="../images/login.png" alt="LogIn">
                        <img class="animate-bottom" src="../images/register.png" alt="Register">
                    </div>
                </div>
            </div>
        </section>
        <!-- Sign up ends-->
        <footer>
            <div class="container" name="footer" id="footer">
                <div class="back-to-top">
                    <i class="fas fa-chevron-up"></i>
                </div>
                <div class="footer-content">
                    <div class="footer-content-about animate-top">
                        <h4>About Hand Me Down</h4>
                        <div class="asterisk"><i class="fas fa-asterisk"></i></div>
                        <p>
                            This is a site for book lovers, created by book lovers. Exchange, sell or donate the books you no
                            longer need, but still love! Rest assured that your books will be just as loved by the new owner…
                            even as Hand-me-downs!
                        </p>
                    </div>
                    <div class="footer-content-divider animate-bottom">
                        <div class="social-media">
                            <h4>Follow along</h4>
                            <ul class="social-icons">
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i> </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-pinterest"></i> </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-linkedin-in"></i> </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-instagram"></i> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="newsletter-container">
                            <h4>Newsletter</h4>
                            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="newsletter-form">
                                <input type="email" name="email" class="newsletter-input" placeholder="Your email address..." required>
                                <button class="newsletter.btn" name="email-submit" type="submit">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <script src="../js/landing.js"></script>
    </body>
</html>