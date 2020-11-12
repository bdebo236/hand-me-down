<?php 
    session_start();
    include 'dbconn.php';        // importing this so we can use the $conn variable everywhere
    if(isset($_GET['user'])) {
        $userDisplay = $_GET['user'];
    } else {
        $userDisplay = "";
    }
    $userExist = true;
?>  

<html>
    <head>
        <title>My Profile - Hand Me Down</title>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- My Scripts -->
        <script src="../js/profile.js"></script>
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="../css/pagetransition.css">
        <script src="../js/pagetransition.js"></script>
    </head>
    <body>
        <div class="pgtransition transition-3 is-active">
            <div class="loading">
                <div class="dot dot-1"></div>
                <div class="dot dot-2"></div>
                <div class="dot dot-3"></div>
            </div>
        </div>
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
                                if(isset($_SESSION['username'])) {
                                    echo '<a href="request-book.php" class="nav-link">Request</a>';
                                } else {
                                    echo '<a href="login.php" class="nav-link">Request</a>';
                                }
                            ?>
                        </li>
                        <li class="nav-item">
                            <a href="sell-book.php" class="nav-link">Donate or Sell</a>
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
                            <a href= <?php echo $link;?> class="nav-link active">My Profile</a>
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

        <section id="hero" class="hero">
            <div class="container">
                <h1>Profile</h1>
                <div id="personal-info">
                    <?php
                        $sql = "SELECT * FROM `users` WHERE username = '$userDisplay'";
                        $result = $conn->query($sql);
                        if ($result->num_rows> 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['name'] . '<br>';
                                echo $row['username'] . '<br>';
                                echo $row['email'] . '<br>';
                                echo $row['city'] . ", " . $row['state'] . ", " . $row['country'] . '<br>';
                            }
                        } else if($userDisplay == "") {
                            echo 'No User Selected';
                            $userExist = false;
                        } else {
                            echo 'User does not exist.';
                            $userExist = false;
                        }
                    ?>
                    <input type="button" id='<?php echo $userDisplay;?>' class="btn-chat" value = "Chat">
                </div>
                <div class="content-divider">
                    <div id="books-requested">
                        <h2>Books requested</h2>
                        <?php
                        if ($userExist) {
                            $sql = "SELECT * FROM `request_books` WHERE request_user = '$userDisplay'";
                            $result = $conn->query($sql);
                            if ($result->num_rows> 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<div class = "display-item">';
                                    echo 'Title: ' . $row['title'] . '<br>';
                                    echo 'Author: ' . $row['author'] . '<br>';
                                    if($row['publisher'] !== "") {
                                        echo 'Publication: ' . $row['publisher'] . '<br>';
                                    }
                                    if ($_SESSION['username'] == $userDisplay) {
                                        echo '<div id=' . $row['id'] . ' class="del-req">Request Fulfilled? <i class="fas fa-trash"></i></div>';
                                    }
                                    echo '<br></div>';
                                }
                            } else {
                                echo $userDisplay . " hasn't requested any books";
                            }
                        }
                        ?>
                    </div>
                    <div id="books-on-sale">
                        <h2>Books On Sale</h2>
                        <?php
                            if ($userExist) {
                                $sql = "SELECT * FROM `book_on_sale` WHERE seller = '$userDisplay'";
                                $result = $conn->query($sql);
                                if ($result->num_rows> 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class = "display-item">';
                                        echo 'Title: ' . $row['title'] . '<br>';
                                        echo 'Author: ' . $row['author'] . '<br>';
                                        if($row['publisher'] !== "") {
                                            echo 'Publication: ' . $row['publisher'] . '<br>';
                                        }
                                        if($row['price'] == 0) {
                                            $row['price'] = 'Free!';
                                        }
                                        echo 'Price: ' . $row['price'] . '<br>';
                                        if ($_SESSION['username'] == $userDisplay) {
                                            echo '<div id=' . $row['id'] . ' class="del-sale">Sold Out? <i class="fas fa-trash"></i></div>';
                                        }
                                        echo '<br></div>';
                                    }
                                } else {
                                    echo $userDisplay . " has nothing on sale right now.";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/landing.js"></script>
    </body>
</html>