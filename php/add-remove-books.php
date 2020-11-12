<?php
    include 'dbconn.php';

    if(isset($_POST['saleId'])) {
        $saleId = $_POST['saleId'];

        $sql_sale = "DELETE FROM `book_on_sale` WHERE id = '$saleId'";
        $conn->query($sql_sale);
    }

    if(isset($_POST['requestId'])) {
        $requestId = $_POST['requestId'];

        $sql_req = "DELETE FROM `request_books` WHERE id = '$requestId'";
        $conn->query($sql_req);
    }

    if(isset($_POST['friendIdfriendId'])) {
        $friendId = $_POST['friendIdfriendId'];
    }
?>
