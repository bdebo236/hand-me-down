<?php

    include 'dbconn.php';        // importing this so we can use the $conn variable everywhere

    $sql = "SELECT * FROM `request_books`";
    $result = $conn->query($sql);
    $i = 0;
    
    if ($result->num_rows> 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="request-book-list" id = book-'.$i.'>'; 
            echo '<table>';
            echo '<tr>';
            echo '<td colspan="2"><span class="book-title">'.$row['title'].'</span><br></td></tr>';
            echo '<tr><td>Applicant: </td><td><a href="profile.php?user='.$row['request_user'].'">'.$row['request_user'] . '</a></td></tr>';
            echo '<tr><td>Author: </td><td>'.$row['author'] . '</td></tr>';
            if ($row['publisher'] !== "") {
                echo '<tr><td>Publisher: </td><td>'.$row['publisher'] . '</td></tr>';
            }
            echo '</table></div><br>';
            $i+=1;
        }
    }
?>