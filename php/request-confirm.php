<?php include 'dbconn.php';        // importing this so we can use the $conn variable everywhere
    session_start();
?>     

<?php
    $title = $author = $publisher = $isbn = "";
    $errors = array('isbn' => '', 'sql' => '', 'exists' => '', 'user' => '');

    if(isset($_POST['request-book'])) { 
        $title = $_POST["title"];
        $author = $_POST["author"];
        $publisher = $_POST["publisher"];
        $isbn = $_POST["isbn"];
        $success = true;
        if(isset($_SESSION['username'])) {
            $request_user = $_SESSION['username'];
        } else {
            $success = false;
            $errors['isbn'] = 'User could not be fetched';
        }

        // title and author validation
        if(empty($title)||empty($author)){
            $errors['empty'] = 'Title and Author cannot be empty.';
            $success = false;
        }
        
        // isbn check
        if(!empty($isbn)) {
            if(!(strlen((string)$isbn) == 13 or strlen((string)$isbn) == 10)) {
                $errors['isbn'] = 'ISBN should be a 13/10digit number.';
                $success = false;
            }
        }

        // checking if the requested book is already up for sale
        if($success) {
            $sql_check = "SELECT * FROM `book_on_sale` WHERE title= '$title' AND author='$author'";
            //echo $sql_check;
            $isOnSale = $conn->query($sql_check);

            if($isOnSale->num_rows> 0) {
                $errors['exists'] = "This book is already up for sale!";
                $success = false;
            }
        }

        // database update
        if($success) {
            $sql = "INSERT into request_books (`request_user`, `title`, `author`, `publisher`, `isbn`) values('$request_user', '$title', '$author', '$publisher', '$isbn')";
            
            if ($conn->query($sql) === true) {
                header("location: request-book.php");
            } else {
                $errors['sql'] =  "Could not update: " . $conn->error;
            }
        }  
    }
?>

<html>
    <head>
        <title>Request Confirm - Hand Me Down</title>
        <link rel="stylesheet" href="../css/sell-book.css">
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/type-animation.js"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script>
            $(document).ready(function() {
                var uniqueID = '<?php echo $_GET["bookID"];?>'
                if(uniqueID != 'notFound') {
                    $.ajax({
                        url: "https://www.googleapis.com/books/v1/volumes/"+uniqueID,
                        datatype: "json",
                        success: function(data) {           
                            $('#title').val(data.volumeInfo.title)
                            $("#title"). attr('readonly','readonly')
                            $('#author').val(data.volumeInfo.authors)
                            $("#author"). attr('readonly','readonly')

                            if (data.volumeInfo.publisher != "") {
                                $('#publisher').val(data.volumeInfo.publisher)
                                $("#publisher"). attr('readonly','readonly')
                            }

                            try {
                                $('#isbn').val(data.volumeInfo.industryIdentifiers[1].identifier)
                                $("#isbn"). attr('readonly','readonly')
                            } catch (TypeError) {
                                //pass
                            }
                        },
                        type: 'GET'
                    })
                }
            })

            $(document).ready(function() {
                $("#goBack").click(function() {
                    window.history.back();
                })
            })
        </script>
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
            <h2 id="title-text">Confirm Details</h2>
                <div id="book-detail-form">
                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                        <label for="title">Title: </label><input type = "text" name = "title" id = "title" value="<?php echo htmlspecialchars($title) ?>" required><br>
                        <label for="author">Author: </label><input type = "text" name = "author" id = "author" value="<?php echo htmlspecialchars($author) ?>" required><br>
                        <label for="publisher">Publisher: </label><input type = "text" name = "publisher" id = "publisher" value="<?php echo htmlspecialchars($publisher) ?>"><br>
                        <label for="isbn">ISBN: </label><input type = "text" name = "isbn" id = "isbn" value="<?php echo htmlspecialchars($isbn) ?>"><br>
                        <span class="error"><?php echo $errors['isbn']?></span><br>

                        <br><br><input type="submit" id = "request-book" name = "request-book" value="Request">
                        <input type="button" id = "goBack" value="Go Back"><br><br>
                        <span class="error"><?php echo $errors['sql']; echo $errors['exists'];?></span><br>
                    </form>
                </div>
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