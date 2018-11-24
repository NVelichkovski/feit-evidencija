<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Календар на активности</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/izvestaj.css" />
	<link rel="stylesheet" href="pure/pure-min.css" />
	<link rel="stylesheet" href="izvestaj.css" />

	<link rel="stylesheet" href="css/notifikacii/css/normalize.css" />
	<link rel="stylesheet" href="css/notifikacii/css/foundation.css" />
</head>
<script>
function f()
{
	document.form1.submit();
alert('Вашата промена е успешно зачувана!');
}

function goBack() {
    window.history.back()
}
</script>

<?php

require_once('funkcii.php');
	if (isset($_GET['id'])) $id = $_GET['id'];
?>
<body>
<button onclick="goBack()"><< Назад</button>


<form method = "POST" id = "form1" name = "form1" onsubmit = "f()">

<?php

$kon = connectToDB();
$prasanje = "SELECT od.datum, p.ime, od.status, od.id, od.profesor, p.id, od.blok 
			FROM odrzana_nastava as od, predmet as p
			WHERE od.id = '".$id."' AND p.id = od.predmet
			";
			echo $prasanje;
session_start();
$rez = mysqli_query($kon,$prasanje);
if(!$rez) header("Location:index.php");
$nas = $rez1[4];
//if($nas!=$_SESSION['id'])header("Location:index.php");
$def = $rez1[1];
$datum = $rez1[0];
$status = $rez1[2];
if($status=='корегирана') header("Location:index.php");
$pid = $rez1[5];
$blok = $rez1[6];

?>	

<?php 
$prasanje = "SELECT p.ime, p.id
			FROM raspored as np, predmet as p
			WHERE np.id_nastavnik = '".$nas."' AND np.id_semestar='".get_id_semestar()."' AND np.id_predmet = p.id ";// AND p.id != '".$pid."'";
$rez = mysqli_query($kon,$prasanje);
?> 
 <table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<td> Датум </td>
			<td></td>
			<td> Предмет по распоред </td>
			<?php 
			if($status=='некорегирана'){
			echo '<td> Замени со </td>
			<td> Блок </td>
			<td> Тема </td> <td> </td>';
			}
			else if($status=='одржана'){
			echo '<td> Тема </td> <td> </td>';
			}
			else if ($status=='неодржана'){echo '<td> Причина за неодржаност </td> <td> </td>';}
			?>
		</tr>
	</thead> 
	<tbody>
		<tr>
			<td> <?php echo $datum; ?> </td>
			<td style="color: red;"> X </td>	
			<td> <?php echo $def; ?> </td>
			<?php 
			if($status=='некорегирана'){
			echo '<td><select name = "predmet">';
		while($pom = mysqli_fetch_array($rez)) { 
		echo '<option value = "'.$pom[1].'"  >'.$pom[0].' </option>';		
		 } 
				echo '</select>	</td><td> 
				<select name = "blok">
				';
					$br = 1;		
			echo '	<option value = "'.$blok.'" selected> '. $blok. ' </option>'; 
				
				
					while($br<7){
					if($br != $blok)
					echo "<option value = $br \>$br</option>";
				
				 $br++; } 
				echo '</select>
			</td>';
			}
			 
			if($status=='одржана'||$status=='некорегирана')echo '<td><input type="text" name="tema"/> </td>';
			else if($status=='неодржана')echo '<td><input type="text" name="tema"/> </td>';
			?>
			<td>  
					<input type="submit" value = "Зачувај" name="kopce"/>
  			</td>
	</tr>
	</tbody>

	</table>


<?php

if(isset($_POST['predmet'])) $predmet = $_POST['predmet'];
else $predmet = $pid;

if(isset($_POST['blok'])) $blok = $_POST['blok'];

$kdatum = date("Y-m-d");
$nov_status="";
if($status=='одржана'){$nov_status='одржанаТ';}
else if($status=='некорегирана'){$nov_status='корегирана';}
else if ($status=='неодржана'){$nov_status='неодржанаТ';}
$prasanje = "UPDATE odrzana_nastava
			 SET predmet = '".$predmet."', status = '".$nov_status."', datum_korekcija = '".$kdatum."', blok = '".$blok."', Tema='".$_POST['tema']."' 
			 WHERE id = '".$id."'  
			";
if(isset($_POST['kopce']))
$rez = mysqli_query($kon,$prasanje);

if(isset($_POST['kopce'])) header('Location:index.php');

?>
</form>


</body>
</html>

