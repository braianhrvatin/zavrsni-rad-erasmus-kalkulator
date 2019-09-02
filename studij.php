<!DOCTYPE html>
<html>
<head>
<script type="text/javascript"src="logika_rada.js"></script> 
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<!--padajuci izbornik sa ponudenim usmjerenjima-->
<select id="usmjerenje_id" name="specijalist" onchange="odabirUsmjerenja(this.value)">
<option disabled selected value> -- Select an orientation program -- </option>
<?php
include('conn.php');
$q=$_GET['q'];
mysqli_set_charset($conn,"utf8");
mysqli_select_db($conn,"ajax_demo");

	$sql="SELECT * FROM usmjerenje WHERE studij =".$q."";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value= " . $row["id"]. ">"  . $row["engNaziv"]."</option>";
    }

}
$conn->close();
?>
</select>
<br>





</body>
</html> 