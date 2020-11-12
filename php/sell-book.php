<html>
    <head>
        <title>Sell A Book - Hand Me Down</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- My Scripts and Links -->
        <script src="../js/sell-book.js"></script>
        <script src="../js/type-animation.js"></script>
        <link rel="stylesheet" href="../css/sell-book.css">
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>
    <body onload="typeWrite()">
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
                                    echo '<a href="#" class="nav-link active">Donate or Sell</a>';
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
                    <h2><span class="first-letter">s</span>ell <span class="first-letter">a</span> <span class="first-letter">b</span>ook</h2>
                    <div id="subheader">
                        <span id="description"></span>
                        <span id="cursor">_</span>
                    </div>
                </div>
                <!-- Title Ends -->

                <div class="search-wrap">
                    <input type="text" name="bookName" id="bookName" placeholder="What do you wanna sell?">
                    <button type="button" id="btn-search"><i class="fas fa-search"></i></button>
                </div>
                <div>
                    <button type="button" id="show-request-btn">Show Request List</button>
                </div>
                <!-- Search Bar Ends -->

                <div id="preview">
                    <div id="result" class="grid-25"></div>
                    <div id="not-found">
                        <input type="button" id="not-found-btn" value="Book Not Found In Result">
                    </div>
                </div>
                <!-- Result Panel Ends -->
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