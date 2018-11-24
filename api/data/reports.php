<?php 
    session_start();
    include_once('../databaseFunctions.php');
    error_reporting(0);

    // if (isset($_SESSION['user'])) {
        if (isset($_GET['action']) && ($_GET['action']=='get_params')) {
            $conn = databaseConnect();
            
            $return = [
                'professors' => [],
                'subjects' => [],
                'semesters' => []
            ];

            if ($_SESSION['user']['privilegii'] == 'prodekan') {
                $query = "SELECT NN.id, NN.ime, NN.prezime FROM nastavnik AS NN order by NN.ime";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){
                    array_push($return['professors'],[
                        'id' => $row['id'],
                        'firstName' => $row['ime'],
                        'lastName' => $row['prezime']
                    ]);
                }
            }
            
            if ($_SESSION['user']['privilegii'] == 'prodekan') {
                $query = "SELECT P.*, NP.id_nastavnik FROM predmet AS P, raspored AS NP WHERE NP.id_predmet=P.id order by P.ime";
            }
            else {
                $query = "SELECT DISTINCT P.*, NP.id_nastavnik FROM predmet AS P, raspored AS NP WHERE NP.id_predmet=P.id AND NP.id_nastavnik=".$_SESSION['user']['id']." order by P.ime";
            }

            $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){
                    array_push($return['subjects'],[
                        'id' => $row['id'],
                        'name' => $row['ime'],
                        'professorId' => $row['id_nastavnik'] 
                    ]);
                }

            $query = "SELECT id, year(prv_den) as god, month(prv_den) as mes FROM semestar order by prv_den";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            {
                array_push($return['semesters'],[
                    'id' => $row['id'],
                    'name' => ($row['mes'] < 6? "Летен " : "Зимски ").$row['god']
                ]);
            }
            echo json_encode($return);
        }
        elseif ((isset($_GET['action']) && ($_GET['action']=='get_report'))) {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $nedela=$request->nedela;
            $semestar=$request->semestar;
            $predmet=$request->predmet;
            $nastavnikPost = $request->nastavnik;

            // $nedela=$_POST['nedela'];
            // $semestar=$_POST['semestar'];
            // $predmet=$_POST['predmet'];
            // $nastavnikPost = $_POST['nastavnik'];

            
            // $nedela= -1;
            // $semestar= -1;
            // $predmet= -1;
            // $nastavnikPost = 1;

            $return = ['subjects' => []];
            $conn = databaseConnect();


            if($semestar!="-1") $semestar=" AND id_semestar='".$semestar."' ";
            else $semestar = '';

            if($predmet!="-1") $predmet=" AND id_predmet ='".$predmet."' ";
            else $predmet = '';

            $nastavnik = "";
         if(isset($nastavnikPost)){ 
                if($nastavnikPost != -1) {
                $nastavnik = "AND id_nastavnik = ".$nastavnikPost." ";
                }
                else {$nastavnik ="";}
            }
            else  $nastavnik = "AND id_nastavnik = ".$_SESSION['user']['id']." ";
            // else  $nastavnik = "AND id_nastavnik =  1 ";
            $query="SELECT r.* FROM raspored as r WHERE id_semestar='".get_id_semestar()."' $nastavnik $semestar $predmet ORDER BY den,termin";
            $report_rez = mysqli_query($conn, $query);
            $query = "SELECT DAY(prv_den),MONTH(prv_den),YEAR(prv_den) FROM semestar WHERE id = (SELECT MAX(id) FROM semestar)";
            $rez = mysqli_query($conn, $query);
            $first_day_arr = mysqli_fetch_array($rez);
            $first_day= jddayofweek(cal_to_jd(CAL_GREGORIAN,$first_day_arr[1],$first_day_arr[0],$first_day_arr[2]),0)-1;
            
            while($row = mysqli_fetch_array($report_rez)){
                $curr_day = $row['den'];
                if($curr_day < $first_day) $curr_day += 7;

                $day_offset = $curr_day - $first_day;
                $beginning_date = date("Y-m-d", strtotime("+".$day_offset." day", strtotime($first_day_arr[2]."-".$first_day_arr[1]."-".$first_day_arr[0])));
                
                if (($row['termin'] + 7) < 10) {
                    $add = '0';
                } else $add = '';
                if ($nedela != -1) {   
                    $datum=date ("Y-m-d", strtotime("+".($nedela-1)." week", strtotime($beginning_date)));
                    array_push($return['subjects'],
                    printaj_predmet_odrzana($row['id_predmet'],$row['id_nastavnik'],$row['termin']+7,$row['termin']+7+$row['blok'],$row['id_prostorija'],$date,$row['termin']+7,$row['tip']));
                }
                else {

                    while (strtotime($beginning_date . " ".$add.($row['termin']+7).":00:00")<strtotime(date("Y-m-d H:i:s"))){
                        array_push($return['subjects'],
                         printaj_predmet_odrzana($row['id_predmet'],$row['id_nastavnik'],$row['termin']+7,$row['termin']+7+$row['blok'],$row['id_prostorija'],$beginning_date,$row['termin']+7,$row['tip'])
                        );
                        $beginning_date=date("Y-m-d", strtotime("+7 day", strtotime($beginning_date)));                       
                }
                
            }

    }
    // $predmet['name'] = $odgovor_predmet[1];
    // $predmet['date'] = $datum;
    // $predmet['professor'] = $odgovor_nastavnik[1].' '.$odgovor_nastavnik[2];
    // $predmet['room'] = $odgovor_prostorija[1];
    // $predmet['start_time'] = $poc;
    // $predmet['end_time'] = $kraj;
    // $predmet['status'] =  $odrzan_rezultat[7];
    // $predmet['students'] = [];

    // array_push($return['subjects'],[
    //     'name' => 'Пробен предмет',
    //     'date' => date('2018-03-05'),
    //     'professor' => 'Некој Некој',
    //     'room' => '232',
    //     'start_time' => 9,
    //     'end_time' => 10,
    //     'status' => 'одржана',
    //     'students' => [
    //         [
    //             'name' => 'Никола Величковски',
    //             'index' => '298/2016',
    //             'recorded' => false
    //         ],
    //         [
    //             'name' => 'Петар Ивановски',
    //             'index' => '224/2016',
    //             'recorded' => true
    //         ]
    //     ]       
    // ]);
    // echo print_r($return);
    echo json_encode($return);
}
	
function get_id_semestar()
{
	$kon = databaseConnect();
	$pocetok_semestar_prasanje="SELECT * FROM semestar ORDER BY id DESC LIMIT 1";
	$pocetok_first_day_arr=mysqli_query($kon,$pocetok_semestar_prasanje);
	$pocetok_semestar = mysqli_fetch_array($pocetok_first_day_arr);
	$datum_pocetok_semestar=$pocetok_semestar[0];
	return $datum_pocetok_semestar;

}

function printaj_predmet_odrzana($predmet_id,$nastavnik_id,$poc,$kraj,$prostorija_id,$datum,$poc1,$tip)
{
                $conn = databaseConnect();
                $predmet =[];
               
                $kveri_nastavnik="SELECT * FROM nastavnik WHERE id='".$nastavnik_id."'";
                $kveri_predmet="SELECT * FROM predmet WHERE id='".$predmet_id."'";
                $kveri_prostorija="SELECT * FROM prostorija where id='".$prostorija_id."'";
               
                $odgovor_nastavnik1=mysqli_query($conn,$kveri_nastavnik);
                $odgovor_predmet1=mysqli_query($conn,$kveri_predmet);
                $odgovor_prostorija1=mysqli_query($conn,$kveri_prostorija);
               
                $odgovor_nastavnik=mysqli_fetch_array($odgovor_nastavnik1);
                $odgovor_predmet=mysqli_fetch_array($odgovor_predmet1);
                $odgovor_prostorija=mysqli_fetch_array($odgovor_prostorija1);
               
                $odrzan_prasanje="SELECT * FROM odrzana_nastava where profesor='".$nastavnik_id."' and predmet='".$predmet_id."' and pocetok='".$poc."' and datum='".$datum."' and prostorija='".$prostorija_id."' and (status='одржана' or status='некорегирана' or status='корегирана' or status='одржанаТ')";
                $odrzan_odgovor=mysqli_query($conn,$odrzan_prasanje);
               
                if(mysqli_num_rows($odrzan_odgovor)>0){$odrzana=1; $odrzan_rezultat=mysqli_fetch_array($odrzan_odgovor); $odrzan_id=$odrzan_rezultat[0];}
                else $odrzana = 0;
               
                $predmet['name'] = $odgovor_predmet[1];
                $predmet['date'] = $datum;
                $predmet['professor'] = $odgovor_nastavnik['ime'].$odgovor_nastavnik['prezime'];
                $predmet['room'] = $odgovor_prostorija[1];
                $predmet['start_time'] = $poc;
                $predmet['end_time'] = $kraj;
                $predmet['status'] =  $odrzana? $odrzan_rezultat[7] : null;
                $predmet['students'] = [];
                if($odrzana){ 
                        $prasanje_studenti="SELECT s.* FROM odrzana_studenti as os, student as s WHERE os.nastava_id='".$odrzan_id."' and os.student_id=s.student_id"; 		
                        $odgovor_studenti=mysqli_query($conn,$prasanje_studenti);
                        while($rowPoseti = mysqli_fetch_array($odgovor_studenti)){
                            $student = [];

                            $student['name'] = $rowPoseti['ime'].' '.$rowPoseti['prezime'];
                            $student['index'] = $rowPoseti['br_indeks'];
                            
                            if(($odgovor_predmet[3]==$rowPoseti[6])||($odgovor_predmet[3]==$rowPoseti[7])||($odgovor_predmet[3]==$rowPoseti[8])||($odgovor_predmet[3]==$rowPoseti[9])||($odgovor_predmet[3]==$rowPoseti[10])||($odgovor_predmet[3]==$rowPoseti[11])||($odgovor_predmet[3]==$rowPoseti[12]))
                                $student['recorded'] = true;
                            else 
                                $student['recorded'] = false;
                            
                                array_push($predmet['students'], $student);           
                        }
                }
                
        return $predmet;
}
