<?php
	session_start();

	if (isset($_SESSION['url'])) {
		unset($_SESSION['url']);
	}

	if (isset($_GET['logout'])) {
		require_once("fonctions.php");
		$url = "http://localhost/site_qcm/index.php";
		$log = auth_cas($url);
	}

	if (!isset($_SESSION['nom']) || $_SESSION['nom'] == '') {
		$_SESSION['url'] = "http://localhost".$_SERVER['REQUEST_URI']; // récupère l'adresse courante
		// url a changé, et renvoyer sur la liste des questionnaire
		header("Location: http://localhost/site_qcm/login");
		exit();
	}

	if (!isset($_SESSION['Statut']) || $_SESSION['Statut'] != "Professeur") {
		$_SESSION['url'] = "http://localhost".$_SERVER['REQUEST_URI']; // récupère l'adresse courante
		header("Location: http://localhost/site_qcm");
		exit();
	}

	/*
	if (isset($_GET['num_qcm'])) {
		$_SESSION['quest'] = $_GET['num_qcm'];
		unset($_GET['num_qcm']);

		header('Location: http://localhost/site_qcm/afficher_qcm.php');
		exit();
	}
	*/

	require_once("connexion_bd.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Consultation des questionnaires</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="functions.js"></script>
</head>

<body>
	<div id="banniere_haut">
		<div id="logo">
			<a href="http://localhost/site_qcm/index.php">
				<img src="images/wolf.jpg" alt="logo_loup" id="mon_logo"/>
			</a>
		</div>
		<div id="div_lien">
			<?php
				$login = $_SESSION['phpCAS']['user'];
				echo '<span class="espacement">';
				echo "Bienvenue $_SESSION[prenom] $_SESSION[nom]";
				echo '</span>';
				
				echo '<a class="lien_connexion" href="http://localhost/site_qcm/Site_Qcm.php?logout=true">Deconnexion</a>';
			?>
		</div>
	</div>

	<div id="page">
		<h2>Liste de vos questionnaires</h2>
		<?php
			$req_questionnaire = "SELECT Titre,Id,Code FROM questionnaire WHERE Login = \"$login\"";
			$reponse = $bdd->query($req_questionnaire);

			echo "<ul class = \"liste_qcm\">";

			while($donnees = $reponse->fetch()) {
				echo "<li>";
					echo "<h3>".$donnees['Titre']."</h3>";
					echo "<p>";
						echo "<table>";
							echo "<tr>";
								echo "<td>";
									echo "<button type=\"button\" onClick=\"window.location='http://localhost/site_qcm/afficher_qcm.php?id_qcm=".$donnees['Id']."';\">Consulter</button>";
								echo "</td>";
								echo "<td>";
									echo "<button type=\"button\" onClick=\"window.location='http://localhost/site_qcm/modifier_qcm.php?id_qcm=".$donnees['Id']."';\">Modifier</button>";
								echo "</td>";
								echo "<td>";
									echo "<button type=\"button\" onClick=\"window.location='http://localhost/site_qcm/consultation_qcm.php?id_supp=".$donnees['Id']."';\">Supprimer</button>";
								echo "</td>";
								echo "<td>";
									echo "<button type=\"button\" onClick=\"copy(document.getElementById('CopyPaste').value);\">Partager</button>";
								echo "</td>";							
							echo "</tr>";
						echo "</table>";
						echo "<input id=\"CopyPaste\" class=\"CopyPaste\" type=\"text\" value = \"http://localhost/site_qcm/questionnaire/?q=".$donnees['Code']."\" disabled />";

					echo "</p>";

				echo "</li>";

			}

			echo "</ul>";
			
			$reponse->closeCursor();
		?>

	</div>
</body>

</html>
