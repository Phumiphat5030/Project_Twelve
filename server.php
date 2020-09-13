<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_twelve";

    //connection
    $con = mysqli_connect($servername, $username, $password, $dbname);

    //checking
    if (!$con){
        die("Connection failed" . mysqli_connect_error());
    } else {}

?>