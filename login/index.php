<?php
	session_start();

	require_once("../fonctions.php");

	if (isset($_SESSION['url'])) {
		$url = $_SESSION['url'];
	}
	else {
		$url = "http://localhost/site_qcm/index.php"; //adresse de base du site
	}

	if (isset($_SESSION['nom'])) {
		header("Location: $url");
		exit();
	}

	if (isset($_GET['authCAS'])) {
		$log = auth_cas($url);
		$info = recupInfosLdap($log);

		$_SESSION['nom'] = $info['nom'];
		$_SESSION['prenom'] = $info['prenom'];
		
		header("Location: $url");
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../style.css" />
        <title>Page de Connexion</title>
	</head>

	<body>
		<div id="banniere_haut">
			<div id="logo">
				<a href="http://localhost/site_qcm/index.php">
					<img src="../images/wolf.jpg" alt="logo_loup" id="mon_logo"/>
				</a>
			</div>
			<div id="div_lien">
			</div>
		</div>

		<div id="page">
			<?php
				if (!isset($_SESSION['nom'])) {
					echo "<p>";
						echo "<a href=\"http://localhost/site_qcm/login/index.php?authCAS=CAS\">Se connecter avec Unilim</a>";
					echo "</p>";
				}
				else {
					echo "<p>";
						echo "Connexion réussi <br/>";
						echo "<a href =\"http://localhost/site_qcm/\">Redirection page d'accueil</a>";
					echo "<p>";
				}
			?>
		</div>
	</body>
</html>
