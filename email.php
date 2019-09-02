<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require './PHPMailer/src/Exception.php';
	require './PHPMailer/src/PHPMailer.php';
	require './PHPMailer/src/SMTP.php';
	
	$adresa=isset($_GET['adresa']) ? $_GET['adresa'] : '';
	$studij=isset($_GET['studij']) ? $_GET['studij'] : '';
	$usmjerenje=isset($_GET['usmjerenje']) ? $_GET['usmjerenje'] : '';
	$semestar=isset($_GET['semestar']) ? $_GET['semestar'] : '';
	$popis=isset($_GET['popis']) ? $_GET['popis'] : '';
	$suma=isset($_GET['suma']) ? $_GET['suma'] : '';
	
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth=true;
	$mail->SMTPSecure='ssl';
	$mail->Host='smtp.gmail.com';
	$mail->Port='465';
	$mail->isHTML();
	$mail->Username='erasmusveleri@gmail.com';//gmail racun
	$mail->Password='erasmusveleri98';//lozinka
	$mail->SetFrom('erasmusveleri@gmail.com');
	$mail->Subject='Erasmus+ selected courses';
	$mail->Body=$studij . "<BR/>" . $usmjerenje . "<BR/>" . $semestar . "<BR/>" . $popis . "<BR/>ECTS sum is " . $suma . "<BR/>";
	$mail->AddAddress($adresa);
	
	//za testiranje ako ne radi (ako ne radi ili fali ssl u php.ini ili avast smeta)
	//$mail->SMTPDebug = 2;
	//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
	$mail->Send();
	
	

?>
</html> 