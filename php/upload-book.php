<?php include 'dbconn.php';        // importing this so we can use the $conn variable everywhere?>     

<?php
    session_start();
    $price = $duration = $image = "";
    $errors = array('empty' => '', 'price' => '', 'duration' => '', 'image' => '', 'checkbox' => '', 'sql' => '');

    if(isset($_POST['sell-book'])) {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $publisher = $_POST["publisher"];
        $isbn = $_POST["isbn"];
        $duration = $_POST["duration"];
        $success = true;
        if(isset($_SESSION['username'])) {
            $seller = $_SESSION['username'];    
        }

        // title and author validation
        if(empty($title)||empty($author)){
            $errors['empty'] = 'Title and Author cannot be empty.';
            $success = false;
        }

        // isbn check
        if(!empty($isbn)) {
            if (is_numeric($isbn)) {
                if(!(strlen((string)$isbn) == 13 or strlen((string)$isbn) == 10)) {
                    $errors['isbn'] = 'ISBN should be a 13/10digit number.';
                    $success = false;
                }
            } else {
                $errors['isbn'] = 'ISBN should be numeric.';
            }
        }

        // checkbox validation
        if(!empty($_POST['donate'])) {
            $donate = $_POST['donate'];
            if($donate[0] == "Sell") {
                $donateVal = false;
            } else if ($donate[0] == "Donate"){
                $donateVal = true;
            }
        } else {
            $errors['checkbox'] = "Please select one option.";
            $success = false;
        }

        // price validation if user wants to sell
        if($success) {
            if($donateVal == false) {
                if(empty($_POST["price"])) {
                    $errors['price'] = "Please enter a price.";
                    $success = false;
                } else if (!is_numeric($_POST["price"])) {
                    $errors['price'] = "Price should be a number.";
                    $success = false;
                } else if ((int)$_POST["price"] <= 0) {
                    $errors['price'] = "Price should be a number greater than 0.";
                    $success = false;
                } else {
                    $price = $_POST["price"];
                }
            } else {
                $price = 0;
            }
        }

        // duration validation
        if($success) {
            if(empty($duration)) {
                $errors['duration'] = "Field can't be empty.";
                $success = false;
            }
        }
        
        // image validation
        if ($success) {
            if (file_exists($_FILES['img-file']['tmp_name']) || is_uploaded_file($_FILES['img-file']['tmp_name'])) {
                $images = $_FILES['img-file'];
                $imageBlob = []; 
                if ($images["error"]) {
                    $errors['image'] = "There was an error uploading picures, please try again";
                    $success = false;
                } else {
                    $file_ext = explode('.', $images["name"]);
                    $ext_check = strtolower(end($file_ext));
                    $valid_ext = 'jpg';
                    if ($ext_check == $valid_ext) {
                        $imageBlob[] = addslashes(file_get_contents($images["tmp_name"]));
                    } else {
                        $errors['image'] = "Only .JPG is allowed";
                        $success = false;
                    }
                }
            } else {
                $errors['image'] = "Please upload atleast one image.";
                $success = false;
            } 
        }

        // if everything succeeds then update database
        if($success) {
            // echo '<br>'.$seller." ".$title." ". $author . " " . $publisher . " " . $isbn . " " . $price . " " . $duration . " " . $donateVal . " " .  print_r($imageBlob);          
            $sql = "INSERT into book_on_sale (`seller`,`title`, `author`, `publisher`, `isbn`, `price`, `donation`, `duration`, `img1`) values('$seller', '$title', '$author', '$publisher', '$isbn', '$price', '$donateVal', '$duration', '$imageBlob[0]')";

            if ($conn->query($sql) === true) {
                header("location: sell-book.php");
            } else {
                $errors['sql'] =  "Could not update: " . $conn->error;
            }
        }  
    }
?>

<html>
    <head>
        <title>Upload Details - Hand Me Down</title>
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- My Scripts and Links -->
        <link rel="stylesheet" href="../css/sell-book.css">
        <script src="../js/upload-book.js"></script>
        <script src="../js/type-animation.js"></script>
        <script src="../js/pagetransition.js"></script>
        <link rel="stylesheet" href="../css/pagetransition.css">
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
            <h2 id="title-text">Fill in Details</h2>
            <div id="book-detail-form">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype = "multipart/form-data">
                    <label for="title">Title: *</label><input type = "text" name = "title" id = "title" required><br>
                    <label for="author">Author: *</label><input type = "text" name = "author" id = "author" required><br>
                    <span class="error"><?php echo $errors['empty']?></span><br>
                    <label for="publisher">Publisher: </label><input type = "text" name = "publisher" id = "publisher"><br>
                    <label for="isbn">ISBN: </label><input type = "text" name = "isbn" id = "isbn"><br>

                    <br><br><label for="donate">Do you wish to Sell/Donate? *</label><br>
                    <input type="radio" name="donate[]" id="donate" value="Donate"><label> Donate </label>
                    <input type="radio" name="donate[]" id="sell" value="Sell"><label> Sell </label><br>
                    <span class="error"><?php echo $errors['checkbox']?></span><br>


                    <br><label for="price">What's your price (in Rs.)? *</label><input type="number" name="price" id="price" value="<?php echo htmlspecialchars($price) ?>" required><br>
                    <span class="error"><?php echo $errors['price']?></span><br>

                    <br><label for="duration">For how long have you owned the book? *</label><input type="text" name="duration" id="duration" value="<?php echo htmlspecialchars($duration) ?>" required><br>
                    <span class="error"><?php echo $errors['duration']?></span><br>

                    <br><label for="user-book-img">Please upload image of your book *</label><input type="file" id="user-book-img" name="img-file" accept="image/*"><br>
                    <span class="error"><?php echo $errors['image']?></span><br>

                    <br><br><input type="submit" id = "sell-book" name = "sell-book" value="Sell">
                    <input type="button" id = "goBack" value="Go Back"><br><br>
                    <span class="error"><?php echo $errors['sql']?></span><br>
                </form>
            </div>
        </section>
        <!-- Form Ends -->

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
        <!-- Toggle Animation Ends -->
    </body>
</html>