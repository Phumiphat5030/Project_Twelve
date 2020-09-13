<?php
       session_start();
       include('server.php');  
       $errors = array();
        
    if (isset($_POST['payment'])) {
        header('location: payment.php');
        }

?>
