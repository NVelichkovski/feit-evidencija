<?php 
    session_start();
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    echo isset($_SESSION)&&isset($_SESSION['user']);
?>