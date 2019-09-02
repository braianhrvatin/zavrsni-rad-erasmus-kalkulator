<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">

<!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
<script type="text/javascript" src="jspdf.debug.js"></script>
<script src="FileSaver.js"></script> 
<script type="text/javascript"src="logika_rada.js"></script> 

</head>

<body>

<h1>Erasmus+ calculator</h1>

<!--padajuci izbornik sa popisom studija-->
<select id="studij_id" onchange="usmjerenje(this)">
<option disabled selected value> -- Select a study program -- </option>

<?php
include('conn.php');

$sql = "SELECT distinct studij.id,studij.engNaziv,studij.department, usmjerenje.studij FROM studij LEFT JOIN usmjerenje ON studij.id = usmjerenje.studij";
mysqli_set_charset($conn,"utf8");
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
		echo "<option value= " . $row["id"]. " data=".$row["studij"].">" . $row["engNaziv"]." - " . $row["department"]. "</option>";
    }
}
$conn->close();
?> 
</select>
<br>
<div id="porukaStudij"><b>Choose a program from the dropdown list.</b></div>

<!--padajuci izbornik sa popisom semestara-->
<select id="IDsemestar" name="ljetoZima" onchange="semestar(this.value)">
<option disabled selected value default="true"> -- Select a semester period -- </option>
<?php

	for($i=1;$i<=2;$i++){
		$ljz="Winter semester";
		if($i%2==0)$ljz="Summer semester";
	echo "<option value= " . $i. ">".$ljz."</option>";
	}
?>
</select>
<br>

<!--popis kolegija ce zamijeniti div element ispod-->
<div id="txtSemestar"><b>Courses will be listed here...</b></div>
<br>

<!--gumbovi za preuzimanje sadržaja-->
<button id="gumb" type="button" onclick="vrstePreuzimanja()">Download selected</button>

<div hidden id="preuzimanja">
<button id="gumb1" type="button" onclick="downloadTxt()">Download txt file</button> 
<button id="gumb2" type="button" onclick="downloadPDF()">Download PDF</button>
<button id="gumb3" type="button" onclick="mail()">Send it as an e-mail</button>
</div>

<!--forma za slanje mail-a -->
<div hidden id="mailform">
	E-mail: <input id="mailadresa" type="mail" value="" required/>
	<button id="gumb4" type="button" onclick="sendMail()">Send</button>
	<div id="porukamail"><b>Please, enter your e-mail adress here.</b></div>
</div>

<p id="thank"></p>
			

</body>
</html> 