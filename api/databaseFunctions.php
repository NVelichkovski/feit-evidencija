<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    function databaseConnect ()
    {
            $dbLink = mysqli_connect(,,,);
                if (mysqli_connect_errno())
                    return "Failed to connect to MySQL: " . mysqli_connect_error();
            mysqli_set_charset($dbLink, "utf8");
            return $dbLink;
    }
    function databaseClose($connectionLink){
        mysqli_close($connectionLink);
    }

    function loginUser($username, $password, $dbLink)
{       //Loging simulation

        if (gettype($dbLink)==='string') {
            return new Error("Invalid database connection");
        }

        if ($username==='student') {
            $query="SELECT * FROM `student` WHERE student_id=3710";
            $rez=mysqli_query($dbLink,$query);
            $_SESSION['user'] = mysqli_fetch_assoc($rez);
            $_SESSION['user']['privilegii']='student';
            $_SESSION['user']['id'] = 3710;
        }elseif ($username==='prodekan') {
            $query="SELECT * FROM nastavnik WHERE id=14";
            $rez=mysqli_query($dbLink,$query);
            $_SESSION['user'] = mysqli_fetch_assoc($rez);
            $_SESSION['user']['privilegii']='prodekan';
            $_SESSION['user']['id'] = 14;
        }else{
            $query="SELECT * FROM nastavnik WHERE id=1";
            $rez=mysqli_query($dbLink,$query);
            $_SESSION['user'] = mysqli_fetch_assoc($rez);
            $_SESSION['user']['privilegii']='nastava';
            $_SESSION['user']['id'] = 1;
        }
        return $_SESSION['user'];
}
?>
