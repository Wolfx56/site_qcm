<?php
	require_once("./fonctions.php");

	if (isset($_GET['authCAS']) || isset($_GET['logout'])) {
		$url = "http://localhost/site_qcm/connexion.php";
		$log = auth_cas($url);

		if (isset($_GET['authCAS'])) {
			$info = recupInfosLdap($log);
			var_dump($info);
		}
	}


?>



<!Doctype HTML>

<html>

<head>
	<title>Test Connexion</title>
	<meta charset="utf-8" />
</head>

<body>

<div id="connexion">
	<?php
		if (! isset($log)) {
			echo '<a href="http://localhost/site_qcm/connexion.php?authCAS=CAS">Connexion</a>';
		}
		else {
			echo $log;
			echo ' <br/> <a href="http://localhost/site_qcm/connexion.php?logout=true"> Deconnexion </a>';
		}
	?>

</div>


</body>

</html>