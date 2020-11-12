<?php include 'dbconn.php';        // importing this so we can use the $conn variable everywhere?>     

<?php
    // this displays all the messages in the chat-log div when we click on any friend button on the left-panel 
    if(isset($_POST['first_receiver'])) {
        $senderUsername = $_POST['first_sender'];
        $receiverUsername = $_POST['first_receiver'];

        $sql1 = "SELECT sender, text_message from chat_log where sender = '$senderUsername' AND receiver = '$receiverUsername' OR sender = '$receiverUsername' AND receiver = '$senderUsername'";
        $msg = $conn->query($sql1);     // extracting all messages sent and received

        $previous = '';
        // echoing them on the chat-log div tag
        if ($msg->num_rows> 0) {
            while($row = $msg->fetch_assoc()) {
                if ($row['sender'] !== $previous) {
                    echo "<div class = 'space'></div>";
                }
                if ($row['sender'] == $senderUsername) {
                    echo "<div class = 'text-msg sender-msg'>";
                } else {
                    echo "<div class = 'text-msg'>";
                }
                echo $row['text_message'];
                echo "</div>";
                $previous = $row['sender'];
            }
        } else {
            echo "No messages, start typing now!";
        }
    }

    if(isset($_POST['msg'])) {
        // this saves the messages in db when user enters new messages
        if(!empty($_POST['msg'])) {
            $senderUsername = strtolower($_POST['sender']);
            $receiverUsername = strtolower($_POST['receiver']);
            $text_message = $_POST['msg'];

            // check if they're friends. if not then add.
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
                $sql_addFren = "INSERT into `friends` (user_one, user_two) values('$senderUsername', '$receiverUsername')";
                $conn->query($sql_addFren);
            }

            // insert sql statement
            $sql = "INSERT into chat_log (sender, receiver, text_message) values('$senderUsername', '$receiverUsername', '$text_message')";
            $conn->query($sql);

            //echoing the new message on chat-log
            echo "<div class = 'text-msg sender-msg'>";
            echo $text_message;
            echo "</div>";
        }
    }

    if(isset($_POST['user'])) {
        $userLoggedIn = $_POST['user'];
        $sql = "SELECT user_two from friends where user_one = '$userLoggedIn' union SELECT user_one from friends where user_two = '$userLoggedIn'";
        $result = $conn->query($sql); // finding all the friends.
        if ($result->num_rows> 0) {
            while($row = $result->fetch_assoc()) {
                $friendUsername = $row['user_two'];
                // each friend becomes one button, upon clicking on will display all the messages on the chat-log
                echo "<li><button value = '$friendUsername' id = '$friendUsername' class = 'friend'>";
                echo $friendUsername;
                echo "</button></li>";
            }
        }
    }
?>