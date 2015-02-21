<?php

$host = "Localhost";
$dname = "site_qcm";
$name = "root";
$pass = "root";

try
{
	$bdd = new PDO("mysql:host=$host;dbname=$dname;charset=utf8", $name, $pass);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

?>