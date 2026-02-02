<?php
    $host = "localhost";
    $username = "NP03CS4A240130";
    $password = "upVN2EIGgC";
    $db_name = "NP03CS4A240130";

    $conn = new mysqli($host,$username,$password,$db_name);
    if($conn->connect_error){
        die("Database connection failed". mysqli_connect_error());
    }
?>