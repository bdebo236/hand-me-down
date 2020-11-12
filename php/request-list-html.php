<html>
    <head>
        <title>Request List - Hand Me Down</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- My Scripts and Links -->
        <link rel="stylesheet" href="../css/sell-book.css">
        <script src="../js/request-list.js"></script>
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
    </head>
    <body>
        <div class="pgtransition transition-3 is-active">
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
                            <a href="landing.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="search-book-html.php" class="nav-link">Search</a>
                        </li>
                        <li class="nav-item">
                            <?php 
                                session_start();
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

        <section>
            <div class="container">
                <div class="heading">
                    <h2><span class="first-letter">r</span>equest <span class="first-letter">l</span>ist</h2>
                    <!--div id="subheader" class="info">Click On Applicant To Start Talking!</div-->
                </div>
                <!-- Title Ends -->

                <div id="result" class="table-result grid-25"></div>
                <!-- Result Display Ends -->
            </div>
        </section>
        <script>
            // Select element function
            const selectElement = function(element){
                return document.querySelector(element);
            };

            let menuToggler = selectElement('.menu-toggle');
            let body = selectElement('body');
            
            //The classList property returns the class name(s) of an element, as a DOMTokenList object.
            menuToggler.addEventListener('click', function(){
                body.classList.toggle('open');         // toggle - if element exists in class then remove it, if it doesn't exist add it
            });
        </script>
    </body>
</html>