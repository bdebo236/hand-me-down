<?php 
    include 'dbconn.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Chat - Hand Me Down</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- My style sheet -->
        <link rel="stylesheet" href="../css/chat-style.css">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <!-- AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            // jQuery event listener to select the chat of one person from right panel
            $(document).ready(function() { // checking if html file is ready for DOM manipulation
                $(".friend").click(function() {  // will get triggered if any button with class friend gets clicked on
                    // saving varaibles to send to php file
                    var senderUsername = '<?php echo $_SESSION["username"];?>'.toLowerCase() // getting sender username from php session
                    var receiverUsername =  $(this).val().toLowerCase(); // each button has the receiver's username as it's value, so we extract that
                    $('#current-user').html(receiverUsername) // printing the name of the selected user above chat-log

                    // calling ajax with post method
                    $.post("load-chat.php", {  // calling load-chat.php
                        // sending these variables as an key-value format
                        first_sender: senderUsername,
                        first_receiver: receiverUsername
                    }, function(data, status) { // after the php function returns anything it gets stored as 'data' and 'status' tells us if the process was successful or not
                        $('#chat-log').html(data) // putting all data we found in the div tag with id = chat-log
                        scrollToBottom()
                        setTimeout(refresh(), 5000)  // calling the refresh() function every 5secs to keep the chat updated
                    }) 
                })
            })

            // refresh friend's list
            function refreshFriends() {
                var sender = '<?php echo $_SESSION["username"];?>'.toLowerCase()
                $.post("load-chat.php", {
                    user: sender
                }, function(data, status) {
                    $('ol').html(data)
                    refresh()
                })
            }

            // This does the same task as previous function but with no trigger, it keeps recalling itself every 3secs
            function refresh() {
                var senderUsername = '<?php echo $_SESSION["username"];?>'.toLowerCase()
                var receiverUsername = $("#current-user").text().toLowerCase()
                $.post("load-chat.php", {
                    first_sender: senderUsername,
                    first_receiver: receiverUsername
                }, function(data, status) {
                    $('#chat-log').html(data)
                    setTimeout(refresh(), 5000)
                })
            }

            // Sending the text message and storing in db
            $(document).ready(function() {  // checking if DOM is ready
                $("#send-msg").click(function() {  // triggered when user presses button with id send-msg
                    // storing sender, receiver and text entered in a variable to send to php file
                    var senderUsername = '<?php echo $_SESSION["username"];?>'.toLowerCase() // extracts session variable saved during sign in
                    var receiverUsername = $("#current-user").text().toLowerCase()
                    var text_msg = $("#input-chat").val()
                    
                    if (receiverUsername == 'Click on a user to start typing!') { // If no user selected then send alert
                        alert('PLease Select a User.')
                    } else { // otherwise call load-chat.php to send the message to db
                        $("#input-chat").val('')
                        $.post("load-chat.php", {
                            sender: senderUsername,
                            receiver: receiverUsername,
                            msg: text_msg
                        }, function(data, status) {
                            $('#chat-log').append(data) // appending the recent text message at the end
                            refreshFriends()
                        })
                    }
                })

                $("#input-chat").keyup(function(event) {  // triggered when user presses button with id send-msg
                    if (event.keyCode === 13) {
                        // storing sender, receiver and text entered in a variable to send to php file
                        var senderUsername = '<?php echo $_SESSION["username"];?>'.toLowerCase() // extracts session variable saved during sign in
                        var receiverUsername = $("#current-user").text().toLowerCase()
                        var text_msg = $("#input-chat").val()
                        
                        if (receiverUsername == 'Click on a user to start typing!') { // If no user selected then send alert
                            alert('Select a User.')
                        } else { // otherwise call load-chat.php to send the message to db
                            $("#input-chat").val('')
                            $.post("load-chat.php", {
                                sender: senderUsername,
                                receiver: receiverUsername,
                                msg: text_msg
                            }, function(data, status) {
                                $('#chat-log').append(data) // appending the recent text message at the end
                                refreshFriends()
                            })
                        }
                    }
                })
            })
            
            // always keep scroll bar at the bottom
            function scrollToBottom() {
                const messages = document.getElementById('chat-log');
                messages.scrollTop = messages.scrollHeight;
            }
        </script>
    </head>
    <body>
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
            <div class="chat-container">
                <div class="left-panel">
                    <div id="friend-heading" class="current-user">Chats</div>
                    <ol>
                    <!--- We call php to find all the friends the current user has and put them on left panel inside buttons --->
                        <?php
                            $userLoggedIn = $_SESSION['username']; // getting current 
                            $sql = "SELECT user_two from friends where user_one = '$userLoggedIn' union SELECT user_one from friends where user_two = '$userLoggedIn'";
                            $result = $conn->query($sql); // finding all the friends. this only returns the user id. user id is an auto increment int value in db
                            if ($result->num_rows> 0) {
                                while($row = $result->fetch_assoc()) {
                                    $friendUsername = $row['user_two'];
                                    // each friend becomes one button, upon clicking on will display all the messages on the chat-log
                                    echo "<li><button value = '$friendUsername' id = '$friendUsername' class = 'friend'>";
                                    echo $friendUsername;
                                    echo "</button></li>";
                                }
                            }
                        ?>
                    </ol>
                </div>
                <!--- Right panel contains chat log and input box --->
                <div class="right-panel">
                <?php
                    if(isset($_GET['new'])) {
                        if ($_GET['new'] == $_SESSION['username']) {
                            echo '<div id = "current-user" class = "current-user">Click on a user to start typing!</div>';
                        } else {
                            $senderUsername = $_SESSION['username'];
                            $receiverUsername = $_GET['new'];
                            $sql = "SELECT user_two from friends where user_one = '$senderUsername' union SELECT user_one from friends where user_two = '$senderUsername'";
                            $result = $conn->query($sql); // finding all the friends.
                            $friendExist = false;
                            if ($result->num_rows> 0) {
                                while($row = $result->fetch_assoc()) {
                                    if($row['user_two'] == $receiverUsername) {
                                        $friendExist = true;
                                    }
                                }
                            }
            
                            if ($friendExist === false) {
                                echo '<div id = "current-user" class = "current-user">'.$_GET['new'].'</div>';
                            } else {
                                echo '<div id = "current-user" class = "current-user">Click on a user to start typing!</div>';
                            }
                        }
                    } else {
                        echo '<div id = "current-user" class = "current-user">Click on a user to start typing!</div>';
                    }
                ?>
                    <div class = "chat-log" id="chat-log"></div>
                    <div class="msg-input-box">
                        <div class="input-wrapper">
                            <input type="text" name="input-chat" id="input-chat" placeholder="Start Chatting!">
                        </div>
                        <button id = "send-msg"><i class="fas fa-paper-plane fa-lg"></i></button>
                    </div>
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