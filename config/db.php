<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "stdrecord";

    $conn = new mysqli($host,$username,$password,$db_name);
    if($conn->connect_error){
        die("Database connection failed". mysqli_connect_error());
    }
?>