<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "stdrecord";

    $conn = new mysqli($host,$username,$password,$db_name);
    if($conn->connect_error){
        die("Database connection failed");
    }else{
        echo "Database connection succesfull";
    }
?>