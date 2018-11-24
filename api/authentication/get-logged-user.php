<?php 
    session_start();
    error_reporting(0);
    if(isset($_SESSION['user'])) {
        $returnValue=[
            'firstName' => $_SESSION['user']['ime'],
            'lastName' => $_SESSION['user']['prezime'],
            'access' => $_SESSION['user']['privilegii']
        ];
        echo json_encode($returnValue);
    }
    else{
        echo json_encode(false);
    }
?>