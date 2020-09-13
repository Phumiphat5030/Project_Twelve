<?php
    session_start();
    include('server.php');  


    if (isset($_POST['pay'])) {

        $amount = mysqli_escape_string($con, $values["item_quantity"] * $values["item_price"]);
        $sql = "INSERT INTO payment (order_id, amount, pay_date) VALUES ('28', '200', '2020-09-11 13:34:56')";
        mysqli_query($con, $sql);
        header('location: TwelveShop.php');
        }
    
    //
?>