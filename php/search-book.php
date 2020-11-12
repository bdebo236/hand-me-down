<?php include 'dbconn.php';        // importing this so we can use the $conn variable everywhere?>  

<?php
    if(isset($_POST['book'])) {
        $book = $_POST['book'];

        $sql1 = "SELECT `seller`, `title`, `author`, `publisher`, `price`, `img1` FROM book_on_sale WHERE `title` LIKE '%$book%' OR `author` LIKE '%$book%' ";
        $result = $conn->query($sql1);
        $i = 1;
        if ($result->num_rows> 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="book-list" id = book-'.$i.'>';
                echo '<span class="book-title">'.$row['title'].'</span><br>';
                session_start();
                if(isset($_SESSION['username'])) {
                    echo 'Seller: <a href="profile.php?user='.$row['seller'].'">'.$row['seller'] . '</a><br>';
                } else {
                    echo 'Seller: <a href="login.php">'.$row['seller'] . '</a><br>';
                }
                
                echo 'Author: '.$row['author'] . '<br>';
                echo 'Publisher: '.$row['publisher'] . '<br>';
                if ($row['price'] == 0) {
                    echo 'Up for Donation!';
                } else {
                    echo 'Price: '.$row['price'] . '<br>';
                }
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img1'] ).'"/>';
                echo '</div>';
                $i+=1;
            }
        }
        else {
            echo '<div class="no-result">Not much to see here... Check the spelling maybe?</div>';
        }
    }
?>