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

	if (!isset($_SESSION['quest'])) {
		$erreur = "Une erreur est survenue, le questionnaire n'a pas pu être affiché";
	}

	if (isset($_POST['submit'])) {
		unset($_SESSION['quest']);
		var_dump($_POST);
		exit();
	}

	require_once("connexion_bd.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Affichage d'un questionnaire</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="functions.js"></script>
</head>

<body>
	<div id="banniere_haut">
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
		<?php
			if (isset($erreur)) {
				echo "<div id=\"erreur\">";
					echo "$erreur";
					echo "<br/>";
					echo "<a href=\"http://localhost/site_qcm/consultation_qcm.php\">Retour a la page des questionnaire</a>";
				echo "</div>";
				exit();
			}

			$code = $_SESSION['quest'];

			//requete, recherche du questionnaire
			$requete = "SELECT questionnaire.Id,Titre,Intitule,Intitule_r,Type,question.Num_q,reponse.Id as rep_id FROM questionnaire NATURAL JOIN question JOIN reponse ON question.Num_q = reponse.Num_q WHERE questionnaire.Code = \"$code\" ORDER BY questionnaire.Id";
			$reponse = $bdd->query($requete);

			$ecrire_titre = 1;
			$intit_reponse = "";

			echo "<form method=\"POST\" action=\"#\">";

			while($donnees = $reponse->fetch()) {
				if ($ecrire_titre) {
					echo "<h2>".$donnees['Titre']."</h2>";
					$ecrire_titre = 0;
					$intit_reponse = $donnees['Intitule'];
					echo "<h5>".$donnees['Intitule']."</h5>";
					echo "<p>";
				}

				if ($intit_reponse != $donnees['Intitule']) {
					$intit_reponse = $donnees['Intitule'];
					echo "</p>"; //on sort de la question précédente
					echo "<h5>".$donnees['Intitule']."</h5>";
					echo "<p>";
				}
				else { //on écrit la réponse courante
					echo $donnees['Intitule_r'];
					if ($donnees['Type'] == 1) { //ajouter un bouton radio
						echo "<input type=\"radio\" name=\"".$donnees['Num_q']."\" value=\"".$donnees['rep_id']."\"";
					}
					else {
						echo "<input type=\"checkbox\" name=\"".$donnees['Num_q']."\" value=\"".$donnees['rep_id']."\"";
					}

					echo "<br/>";
				}


			}
			echo "</p>";

			echo "<input type=\"submit\" value=\"Soumettre le questionnaire\" name=\"submit\"/>";

			echo "</form>";

			$reponse->closeCursor();

		?>

		<!--
			Requetes à la base de donnée;
		-->
	</div>

</body>

</html>
