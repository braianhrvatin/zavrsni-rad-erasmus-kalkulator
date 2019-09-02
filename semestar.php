<!DOCTYPE html>
<html>
<head>
<script type="text/javascript"src="logika_rada.js"></script> 
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div id="blokiraj">

<?php
include('conn.php');
$q=$_GET['q'];
$studij=$_GET['studij'];
$usmjerenje=$_GET['usmjerenje'];
mysqli_set_charset($conn,"utf8");
mysqli_select_db($conn,"ajax_demo");
	
	if($usmjerenje==0){
		if($q==2){
			$sql="SELECT * FROM kolegij where (semestar % 2)=0 and naziv not like '%Izborni%' and studij=".$studij."";
			$sql2 ="SELECT izborni.id,izborni.engNaziv, izborni.kolegij, kolegij.id,kolegij.ects,kolegij.studij,kolegij.semestar FROM kolegij INNER JOIN izborni ON kolegij.id=izborni.kolegij where studij=".$studij." and (semestar % 2)=0 group by izborni.naziv";
		
		}else{
			$sql="SELECT * FROM kolegij where (semestar % 2)!=0 and naziv not like '%Izborni%' and studij=".$studij."";
			$sql2 ="SELECT izborni.id,izborni.engNaziv, izborni.kolegij, kolegij.id,kolegij.ects,kolegij.studij,kolegij.semestar FROM kolegij INNER JOIN izborni ON kolegij.id=izborni.kolegij where studij=".$studij." and (semestar % 2)!=0 group by izborni.naziv";
		
		}
	}else{
		if($q==2){
			$sql="SELECT * FROM kolegij where (semestar%2)=0 and naziv not like '%Izborni%' and studij=".$studij." and (usmjerenje=".$usmjerenje." or usmjerenje IS NULL)";
			$sql2 ="SELECT izborni.id,izborni.engNaziv, izborni.kolegij, kolegij.id,kolegij.ects,kolegij.studij,kolegij.semestar,kolegij.usmjerenje FROM kolegij INNER JOIN izborni ON kolegij.id=izborni.kolegij where studij=".$studij." and (semestar % 2)=0 and(usmjerenje=".$usmjerenje." or usmjerenje is null) group by izborni.naziv"; 
		}else{
			$sql="SELECT * FROM kolegij where (semestar % 2)!=0 and naziv not like '%Izborni%' and studij=".$studij." and (usmjerenje=".$usmjerenje." or usmjerenje IS NULL)";
			$sql2 ="SELECT izborni.id,izborni.engNaziv, izborni.kolegij, kolegij.id,kolegij.ects,kolegij.studij,kolegij.semestar,kolegij.usmjerenje FROM kolegij INNER JOIN izborni ON kolegij.id=izborni.kolegij where studij=".$studij." and (semestar % 2)!=0 and(usmjerenje=".$usmjerenje." or usmjerenje is null) group by izborni.naziv";
		}
	}

	
	$result = $conn->query($sql);//upit za ispis kolegija
	$result2 = $conn->query($sql2);//upit za ispis izbornih
	

	
	$i=1;
	if ($result->num_rows > 0) {
    // output data of each row
	
	echo '<h2>List of regular courses: </h2>';
	echo "<table style='background-color:white;'>";
    while($row = $result->fetch_assoc()) {
	
		echo "<tr>";
		echo "<td><input type='checkbox' name=\"" . $row["engNaziv"] . "\" value= " . $row["ects"]. " onclick='zbroj(this)' id='kol_".$i."'/>"."</td><td>".$row['engNaziv']." </td><td> ". $row["ects"]." ECTS </td>";
		$i++;
		echo "</tr>";
    }
	echo "</table>";
	}
	
	if ($result2->num_rows > 0) {
    // output data of each row
	
	echo '<h2>List of elective courses: </h2>';
	echo "<table style='background-color:white;'>";//<table style="width:324px;">
    while($row = $result2->fetch_assoc()) {
	
		echo "<tr>";
		echo "<td><input type='checkbox' name=\"" . $row["engNaziv"] . "\" value= " . $row["ects"]. " onclick='zbroj(this)' id='kol_".$i."'/>"."</td><td>".$row['engNaziv']." </td><td> ". $row["ects"]." ECTS </td>";
		$i++;
		echo "</tr>";
	}
	echo "</table>";
}

$conn->close();
?>
</div>
<br>
<!--okvir sa ispisom broja ECTS bodova-->
Sum of ECTS credits:
<input disabled class="sumaIspis" type="text" id="zbrojEcts" value="0"/>
<button onclick="resetSum()">Reset selected</button> 

</body>
</html> 