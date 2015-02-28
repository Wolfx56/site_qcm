<?php
	session_start();

	if (isset($_GET['logout'])) {
		require_once("fonctions.php");
		$url = "http://localhost/site_qcm/test_site_qcm.php";
		$log = auth_cas($url);
	}

	if (!isset($_SESSION['nom']) || $_SESSION['nom'] == '') {
		header('Location: index.php');
		exit();
	}

?>

<!--
	Pour la page css : 
	Il faut utiliser l'élément class, Et oui, aucun élément n'est unique
		- Le titre : class = "champ_titre"
		
		- La question 
			div de la question 	:	class = "div_question"
			input texte			:	class = "champ_q"
			bouton ajout rep 	:	class = "button_rep"
			bouton sup_question	:	class = "button_sup_q"

		- La réponse (la réponse sera dans la div question)
			div de la réponse 	:	class = "div_reponse"
			input texte 		:	class = "champ_r"
			input radio			:	class = "champ_radio_r"
			input checkbox		:	class = "champ_checkbox_r"
			bouton sup_reponse	:	class = "button_supp_r"

		- Les boutons ajout de question
			class = "ajout_q"
			id = "ajout_q_u" pour unique
			id = "ajout_q_m" pour multiple

		- Le bouton envoyer 
			class = "button_submit"
-->


<!DOCTYPE html>

<html>
	<head>
		<title>Test Site QCM</title>
		<meta charset="utf-8"/>
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
					
					echo '<a class="lien_connexion" href="http://localhost/site_qcm/test_site_qcm.php?logout=true">Deconnexion</a>';
				?>
			</div>
		</div>


		<div id="page">
			<form method="POST" action="traitement.php" name="questionnaire"  onsubmit="return soumettre_form()">
				<input type="text" placeholder="Titre" name="titre" class="champ_titre" required/>

				<input type="button" onclick="javascript:ajouter_question(j,this)" value="Ajouter question unique" class = "ajout_q" id="ajout_q_u"/>
				<input type="button" onclick="javascript:ajouter_question_mult(j,this)" value="Ajouter question multiple" class = "ajout_q" id="ajout_q_m" />
				
				<div id="envoyer">
					<input type="submit" name="val" value="Valider" class="button_submit"/>
				</div>

			</form>
		</div>
	</body>

</html>