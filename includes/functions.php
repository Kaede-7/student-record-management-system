<?php
    function check_login() {
        if(!isset($_SESSION["user_id"])){
            header("Location: public/login.php");
            exit();
        }
    }
?>