<?php
    include_once("../databaseFunctions.php");
    error_reporting(0);
   function get_id_semestar()
        {
            $kon = databaseConnect();
            $pocetok_semestar_prasanje="SELECT * FROM semestar ORDER BY id DESC LIMIT 1";
            $pocetok_semestar_odgovor=mysqli_query($kon,$pocetok_semestar_prasanje);
            $pocetok_semestar = mysqli_fetch_array($pocetok_semestar_odgovor);
            $datum_pocetok_semestar=$pocetok_semestar[0];
            return $datum_pocetok_semestar;
        }

    if ($_GET['action'] === 'get_notifications') {
        if ($_SESSION['user']['privilegii'] !== 'student' && isset($_SESSION['user']['id'])) {
            $conn = databaseConnect();
            $query = "SELECT od.datum, p.ime, od.status, od.id 
            FROM odrzana_nastava as od, predmet as p
            WHERE od.profesor = '".$_SESSION['user']['id']."' AND p.id = od.predmet AND od.status IN ('одржана','некорегирана','неодржана')";
            if($rez = mysqli_query($conn, $query))
            {
                $return = [
                    'notifications' => [],
                    'subjects' => []
                ];

                
                while($row = mysqli_fetch_array($rez)){
                    array_push($return['notifications'], [
                        'id' => $row[3],
                        'date' => $row[0],
                        'subject' => $row[1],
                        'status' => $row[2],
                        'submited' => 'no',
                        'tema' => ''
                    ]);
                }
                
                $query="SELECT p.ime, p.id
                FROM raspored as np, predmet as p
                WHERE np.id_nastavnik = '".$_SESSION['user']['id']."' AND np.id_semestar='".get_id_semestar()."' AND np.id_predmet = p.id";
                $rez = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($rez)){
                    // var_dump($row);
                     array_push($return['subjects'], $row);
                 }
                //  var_dump($return);
            echo json_encode($return);
            }
        }else {
            // Ne moze da se zemat notifikacii
            return false;
        }
    }
    elseif ($_GET['action'] === 'submit') {
        $conn = databaseConnect();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata); 
        if(isset($request->block)) $block = "blok = '".($request->block)."',";
        else $block ="";

        $status = $request->status;
        if($status=='одржана'){$status='одржанаТ';}
        else if($status=='некорегирана'){$status='корегирана';}
        else if ($status=='неодржана'){$status='неодржанаТ';}

        $id = $request->id;
        $tema = $request->tema;
        $date = date("Y-m-d");
        $query = "UPDATE odrzana_nastava
        SET predmet = '".$id."', status = '".$status."', datum_korekcija = '".$date."', $block Tema='".$tema."' 
        WHERE id = '".$id."'";
        // UPDATE odrzana_nastava SET predmet = '8632', status = 'неодржанаТ', datum_korekcija = '2018-08-04',  Tema='dsf'WHERE id = '1'
        // echo json_encode($query);
        echo mysqli_query($conn, $query) !== false;
    }
?>
