<?php 
session_start();
error_reporting(0);

require_once('./databaseFunctions.php');

$dbLink=databaseConnect();
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if ($_GET['action']=='login') {
    $username=$request->username;
    $password=$request->password;
    if(gettype($dbLink) === 'string'){
        // Connection with Database is death
    }
    else {
            loginUser($username,$password,$dbLink);
            $return = [
                    'firstName' => $_SESSION['user']['ime'],
                    'lastName' => $_SESSION['user']['prezime'],
                    'access' => $_SESSION['user']['privilegii']
            ];
            header('Content-type: text/plain; charset=utf-8');
            echo json_encode($return);
        }
} elseif ($_GET['action']=='logout') {
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    echo isset($_SESSION)&&isset($_SESSION['user']);
}
elseif ($_GET['action']=='get_user') {
    if(isset($_SESSION['user'])) {
        $returnValue=[
            'firstName' => $_SESSION['user']['ime'],
            'lastName' => $_SESSION['user']['prezime'],
            'access' => $_SESSION['user']['privilegii']
        ];
        echo json_encode($returnValue);
    }
    else{
        echo json_encode(isset($_SESSION['user']));
    }
}
mysqli_close($dbLink);