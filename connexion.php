<?php
	require_once("./fonctions.php");

	if (isset($_GET['authCAS'])) {
		echo "set";
		$login = auth_cas("http://localhost/site_qcm/connexion.php");
		echo "set";

		var_dump($login);

		$info = recupInfosLdap($login);

		var_dump($info);
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
	<a href="http://localhost/site_qcm/connexion.php?authCAS=CAS">Connexion</a>


</div>


</body>

</html>