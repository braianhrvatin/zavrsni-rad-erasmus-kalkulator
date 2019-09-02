 <?php

$servername = "ucka.veleri.hr";
$username = "erasmus";
$password = "11";
$dbname = "erasmus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>