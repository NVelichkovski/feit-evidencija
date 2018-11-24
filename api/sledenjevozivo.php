<?php
// Moi funkcii
include_once('databaseFunctions.php');
error_reporting(0);
//-------------------------------------------------------------------------------------------------------
function get_id_semestar()
{
	$kon = databaseConnect();
	$pocetok_semestar_prasanje="SELECT * FROM semestar ORDER BY id DESC LIMIT 1";
	$pocetok_semestar_odgovor=mysqli_query($kon, $pocetok_semestar_prasanje);
	$pocetok_semestar = mysqli_fetch_array($pocetok_semestar_odgovor);
	$datum_pocetok_semestar=$pocetok_semestar[0];
	return $datum_pocetok_semestar;

}
//--------------------------------------------------------------------------------------------------
function vrati_studenti($prof_id,$datum,$prostorija_id,$tip,$poc,$kraj,$pime){
						//n.id , datata, p.id, ovde treba da ime tip na nastava,r.termin + 7, (r.termin+r.blok) + 7,pr.ime
						// gi vraka site studenti koi se prisutni na dadeniot nastan 
	$time = strtotime($datum);
	$god = date('Y',$time);
	$mesec = date('m',$time);
	$den = date('d',$time);

	$kon = databaseConnect();

	$vrti=$kraj-$poc;			// $vrti e kolku casa ima 
	$prasanje="";
	$poc1=$poc;
	/*while($vrti--)
	{
		if($prasanje!="") $prasanje=$prasanje." UNION ";
		$prasanje = "SELECT s.ime, s.prezime, s.br_indeks, p.ime, ns.cas, na.ime, na.prezime,r.blok,r.termin 
				FROM student AS s, nastani_s AS ns, prostorija AS p, nastavnik AS na,raspored as r
				WHERE s.student_id = ns.id_student
				AND na.id='".$prof_id."'
				AND p.id = ns.id_prostorija
				AND p.id = '".$prostorija_id."'
				AND year( ns.cas ) = '".$god."'
				AND month( ns.cas ) = '".$mesec."'
				AND day( ns.cas ) = '".$den."'
				AND r.id_prostorija = '".$prostorija_id."'
AND ( ('".$poc1."'=hour(ns.cas)	AND minute(ns.cas)<=15) OR ('".$poc1."'-1=hour(ns.cas) AND minute(ns.cas)>=45) )";
		$poc1++;
		}*/
$prasanje_studenti=""; 

// Vrti n pati i zgolemuva 
while($vrti--){
if($prasanje_studenti!=""){$prasanje_studenti=$prasanje_studenti." UNION DISTINCT ";}
$prasanje_studenti .= "SELECT DISTINCT s.ime, s.prezime, s.br_indeks
				FROM student AS s, nastani_s AS ns, prostorija AS p
				WHERE s.student_id = ns.id_student
				AND p.id = ns.id_prostorija
				AND p.id = '".$prostorija_id."'
				AND year( ns.cas ) = '".$god."'
				AND month( ns.cas ) = '".$mesec."'				
				AND day( ns.cas ) = '".$den."'
AND ( ('".$poc1."'=hour(ns.cas)	AND minute(ns.cas)<=15) OR ('".$poc1."'-1=hour(ns.cas) AND minute(ns.cas)>=45) )";
$poc1++;
}
/*$pom="";
	if($prasanje!="") 
	{
	if(!$kon) // "padna kon";
	$rezz = mysqli_query($kon,$prasanje);	
	if(!$rezz) die('invalid'. mysqli_errno($rezz));
	else " pomina";		
	$pom = mysqli_fetch_array($rezz);
}
else $pom=array(9);*/
return $prasanje_studenti;
}


//------------------------------------------------------------------------------------------------------------------

function proverka_datum_semestar($datum){ // ja koristi ovaa fja za $ne_printaj
	$kon = 	databaseConnect();						
	$pocetok_semestar_prasanje="SELECT * FROM semestar ORDER BY id DESC LIMIT 1";
	$pocetok_semestar_odgovor=mysqli_query($kon,$pocetok_semestar_prasanje);
	$pocetok_semestar = mysqli_fetch_array($pocetok_semestar_odgovor);
	$datum_pocetok_semestar=$pocetok_semestar[1];
	//$datum="04-11-2016";
	$date1=strtotime($datum);								
	$date2=strtotime($datum_pocetok_semestar);					
	$ucebna_nedela=floor(($date1-$date2)/604800);		
	$ucebna_nedela++;
	$ne_printaj=0;
	// 0 e da ne printa
	// 1 semestarot ne e seuste pocnat;
	// 2 prva kolokviumska nedela
	// 3 vtora kolokviumska nedela 
	// 4 zavrsen e semestarot
	$pocetok_prv_kolokvium=strtotime('+'.(6-date("w",strtotime('+7 weeks', $date2))).' days',strtotime('+7 weeks', $date2));
	$kraj_prv_kolokvium= strtotime('+1 weeks',$pocetok_prv_kolokvium);
	$pocetok_vtor_kolokvium=strtotime('+14 weeks', $date2);
	$kraj_vtor_kolokvium=strtotime('+1 weeks',$pocetok_vtor_kolokvium);
	// // " --> prv kolokvium ".date("d-m-Y",$pocetok_vtor_kolokvium)." <br>";
	if($date1<$date2) $ne_printaj=1;		
	if(($date1>=$pocetok_prv_kolokvium)&&($date1<=$kraj_prv_kolokvium))$ne_printaj=2;
	if(($date1>=$pocetok_vtor_kolokvium)&&($date1<=$kraj_vtor_kolokvium)) $ne_printaj=3;
	if($date1>=$kraj_vtor_kolokvium) $ne_printaj=4;			
	return $ne_printaj;													// samo koga $ne_printaj == 0 togas ke se 		
//popolnuva tabelata za vo sledenje vo zivo 
}

//---------------------------------------------------------------------------------------------------------------------

$date=new DateTime(null, new DateTimeZone('Europe/Berlin'));
// $date = new DateTime('2018-18-04 11:20:00:00', new DateTimeZone('Europe/Berlin'));
$date = new DateTime('2018-03-05 11:11:51.206344', new DateTimeZone('Europe/Berlin'));
$date1=$date->format('d-m-Y');										// ova $date1 e momentalnata data
// za testiranje
$ne_printaj=proverka_datum_semestar($date1);						// $ne_printaj go korsiti dole za da znae so da isprinta 
$date1=strtotime($date->format('d-m-Y'));					// dali e prva kol nedela, vtora, dali e zavrsen semestarot ili 																		// ne e pocnat voopsto

//// " -".$ne_printaj." Ucebna nedela <br>";

if($ne_printaj==0){													
	$den=(date("w", $date1) + 6) % 7;
//// "<br> Den vo nedelata ". $den. " --<br>";
	$hour=$date->format('H');									// gi koristi vo queryto ovie $den $hour
	$min=$date->format('i');
//$min = $min - 7;
//if($min<0){ $min = 60 +$min; $hour--;}
//$den=0;//samo za testiranje
	$hour-=7;
//$hour=1; // samo za testiranje
	$pras = "SELECT p.ime, pr.ime, n.ime, n.prezime, n.id as ajdi, pr.id, r.termin as tpoc, (r.termin+r.blok) as tkraj, p.id as id_prostorija FROM raspored as r, prostorija as p, predmet as pr, nastavnik as n WHERE r.id_semestar='".get_id_semestar()."' and r.den='".$den."' and r.id_semestar='".get_id_semestar()."' and r.id_prostorija=p.id and pr.id=r.id_predmet and r.id_nastavnik=n.id AND r.termin<=".$hour." and (r.termin+r.blok)>".$hour." order by p.ime";
//	// "<br> ".$pras. "<br>";										// dva pati sporeduva r.id_semestar='".get_id_semestar()."
// valjda greska 
$kon=databaseConnect();
	$rezz = mysqli_query($kon,$pras);									
					//// "ima ".mysqli_num_rows($rezz)." redici";
					$prostorii=array();
					$predmeti=array();
					$prof=array();					// nizive gi koristi za da ja stavi celata data od queryto  samo posebno 
					$greski=array();					// ustvari edna niza e edna kolona vo tabelata 
					$gresen_nastavnik=array();
					$br_studenti=array();
					while($pom = mysqli_fetch_array($rezz))
					{
//// "zapis: ".$pom[0]." - " . $pom[1]." <br>";
						array_push($prostorii, $pom[0]);
						array_push($predmeti,$pom[1]);
						array_push($prof,"$pom[2] $pom[3]");			// cetvrtiot argument e 1 valjda samo za predavanja e  
						$prasanje_studenti=vrati_studenti($pom[4],date("Y-m-d"),$pom[8],1,($pom[6]+7),($pom[7]+7),$pom[1]);
//n.id , datata, p.id, 1, r.termin + 7, (r.termin+r.blok) + 7,pr.ime
						$odgovor_studenti=mysqli_query($kon,$prasanje_studenti);
						array_push($br_studenti,mysqli_num_rows($odgovor_studenti));
						$tekoven_cas=$hour=$date->format('H');
						//$tekoven_cas=9;//samo za testiranje
						$tekoven_cas-=7;
						$poc=$pom[6];
						$prasanje="SELECT n.id_nastavnik, ns.ime, ns.prezime FROM nastani as n, nastavnik as ns WHERE n.id_prostorija=".$pom[8]." and ns.id=n.id_nastavnik and DATE(n.cas)=CURDATE() and (weekday(n.cas))=".$den;//." and (";
						//// $prasanje . "</br>";						// ova query go koristi za da vidi dali nastavnicite bile 
																				// prisutni 
						//$tekoven_cas=1;//samo za testiranje
						$novo_prasanje="";
					for($i=$poc+7;$i<=$tekoven_cas+7;$i++){
						
						// SELECT DISTINCT s.ime, s.prezime, s.br_indeks FROM student AS s, nastani_s AS ns, prostorija AS p WHERE s.student_id = ns.id_student AND p.id = ns.id_prostorija AND p.id = '6' AND year( ns.cas ) = '2018' AND month( ns.cas ) = '08'	AND day( ns.cas ) = '03' AND ( ('9'=hour(ns.cas)	AND minute(ns.cas)<=15) OR ('9'-1=hour(ns.cas) AND minute(ns.cas)>=45) ); 
						// UNION DISTINCT SELECT DISTINCT s.ime, s.prezime, s.br_indeks FROM student AS s, nastani_s AS ns, prostorija AS p WHERE s.student_id = ns.id_student AND p.id = ns.id_prostorija AND p.id = '6' AND year( ns.cas ) = '2018' AND month( ns.cas ) = '08'	AND day( ns.cas ) = '03' AND ( ('10'=hour(ns.cas)	AND minute(ns.cas)<=15) OR ('10'-1=hour(ns.cas) AND minute(ns.cas)>=45) ); 
						$prasanje="UNION DISTINCT SELECT DISTINCT s.ime, s.prezime, s.br_indeks FROM student AS s, nastani_s AS ns, prostorija AS p WHERE s.student_id = ns.id_student AND p.id = ns.id_prostorija AND p.id = '6' AND year( ns.cas ) = '2018' AND month( ns.cas ) = '08'	AND day( ns.cas ) = '03' AND ( ('11'=hour(ns.cas)	AND minute(ns.cas)<=15) OR ('11'-1=hour(ns.cas) AND minute(ns.cas)>=45) );";

						$novo_prasanje.="(hour(n.cas)=".($i-1)." and minute(n.cas)>=45) or (hour(n.cas)=".$i." and minute(n.cas)<=15)";
					if($i<$tekoven_cas+7) $novo_prasanje.=" or ";
					}
					if($novo_prasanje!=""){
					$prasanje.=" and (" . $novo_prasanje . ")";}
					//$prasanje.=")";
				//// $prasanje."</br>";
				$odgovor=mysqli_query($kon,$prasanje);
				$nast_id=$pom['ajdi'];		// n.id
				$gr=-1;
				$br=0;
				$grnst="Нема наставник";
				if($odgovor!==FALSE){				// ako nastavnikot dosol
					//// "Nastavnik: $nast_id ";
					while($pom2=mysqli_fetch_array($odgovor)){
					//// "$pom2[0] $nast_id - ";
					$br++;
					
					if(($gr==-1)&&($pom2[0] != $nast_id)){ $gr=1;$grnst="$pom2[1] $pom2[2]"; }		
					if($pom2[0]==$nast_id) {$gr=0;break;}
					}
				}
				if($br==0) $gr=1;
				//// "<br>";
				array_push($greski,$gr);
				array_push($gresen_nastavnik,$grnst);			// vo nizata $gresen_nastavnik se stavaat iminjata na profesorite 
																// a ako profesorot ne bil vo nejze se stava samo "Нема Наставник"
				
	}
}
$return = [
	'semester' => $ne_printaj,
	'streamData' => []
];
for($i=0;$i<count($prostorii);$i++){
	// Go zemav od dolu
	$gresen_nast="";
	if($greski[$i]==1) $gresen_nast="Грешка: $gresen_nastavnik[$i]";

	if($greski[$i]==0||$gresen_nastavnik[$i]!="Нема наставник")$studenti_br=$br_studenti[$i];
	else $studenti_br="-----";
	// Do tuka


	array_push($return['streamData'],[
		'success' => ($greski[$i]==0),
		'room' => $prostorii[$i],
		'subject' => $predmeti[$i],
		'professor' => $prof[$i],
		'currently' => $gresen_nast,
		'present' => $studenti_br === "-----"? 0 : $studenti_br
	]);
}
echo json_encode($return);
?>

