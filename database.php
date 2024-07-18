<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saadweb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

?>
