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

	require_once("../connexion_bd.php");

	if (isset($_POST['submit'])) { //le questionnaire a été répondu
		//unset($_SESSION['quest']);
		var_dump($_POST);

		$nb_points = 0;

		$mycpt = 1;

		$compteur_rep_m = 1;

		while ($mycpt <= $_POST['Nbq']) {
			$nom_question = "Numq".$mycpt;
			if (isset($_POST[$nom_question])) {
				$num_question = $_POST[$nom_question];

				//récupérer le type de la question
				$requete = "SELECT Type FROM question WHERE Num_q = \"$num_question\"";
				$reponse = $bdd->query($requete);
				$donnees = $reponse->fetch();

				//var_dump($donnees);

				if ($donnees['Type'] == 1) { //radio
					if (isset($_POST[$num_question])) { //vérifier qu'on a au moins rentré une réponse
						$num_reponse = $_POST[$num_question];

						//requete pour savoir si la reponse est juste
						$requete = "SELECT Juste FROM reponse WHERE Id = \"$num_reponse\"";
						$reponse = $bdd->query($requete);
						$donnees_r = $reponse->fetch();

						if ($donnees_r['Juste'] == 1) {
							$nb_points ++; //si la reponse est juste, on s'ajoute 1 pt
						}					
					} //end isset
				}
				else { //checkbox
					// récupérer le nombre de réponses de la question 
					$requete = "SELECT Count(*) FROM reponse WHERE Num_q = \"$num_question\"";
					$reponse = $bdd->query($requete);
					$donnees_nb_rep = $reponse->fetch();

					while ($compteur_rep_m <= $donnees_nb_rep['0']) {
						$myreponse = $num_question."+".$compteur_rep_m;
						if (isset($_POST[$myreponse])) {// si ma reponse est défini, donc envoyée dans le formulaire on peut tester
							$num_reponse = $_POST[$myreponse];

							$requete = "SELECT Juste FROM reponse WHERE Id = \"$num_reponse\"";
							$reponse = $bdd->query($requete);
							$donnees_r = $reponse->fetch();

							if ($donnees_r['Juste'] == 1) {
								$nb_points += 1/$donnees_nb_rep['0']; //si la reponse est juste, on ajoute 1/nb_reponse_juste
							}
						}
						$compteur_rep_m ++;
					}
				}// end else
			} // end isset question

			$compteur_rep_m = 1;
			$mycpt ++;
		} // end while question

		echo "Nombre de points : ".$nb_points."<br/>";

		$moyenne = $nb_points/$_POST['Nbq'] * 10;

		echo "<br/>Moyenne : ".$moyenne."/10";

		/*
			Enregistrer la note à l'étudiant 
			Vérifier si il peut répondre au questionnaire en rajoutant un champ dans la base de donnée au questionnaire
		*/

		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Affichage d'un questionnaire</title>
	<link rel="stylesheet" type="text/css" href="../style.css"/>
	<script type="text/javascript" src="functions.js"></script>
</head>

<body>
	<div id="banniere_haut">
		<div id="logo">
			<a href="http://localhost/site_qcm/index.php">
				<img src="../images/wolf.jpg" alt="logo_loup" id="mon_logo"/>
			</a>
		</div>
		<div id="div_lien">
			<?php

				$login = $_SESSION['phpCAS']['user'];
				echo '<span class="espacement">';
				echo "Bienvenue ".ucfirst (strtolower($_SESSION['prenom']))." $_SESSION[nom]";
				echo '</span>';
				
				echo '<a class="lien_connexion" href="http://localhost/site_qcm/Site_Qcm.php?logout=true">Deconnexion</a>';
			?>
		</div>
	</div>

	<div id="page">
		<?php
			if (isset($_GET['q'])) {
				$code = $_GET['q'];
				unset($_GET['q']);

				//requete, recherche du questionnaire
				$requete = "SELECT questionnaire.Id,Titre,Intitule,Intitule_r,Type,question.Num_q,reponse.Id as rep_id FROM questionnaire NATURAL JOIN question JOIN reponse ON question.Num_q = reponse.Num_q WHERE questionnaire.Code = \"$code\" ORDER BY questionnaire.Id";
				$reponse = $bdd->query($requete);

				//$ecrire_titre = 1;
				//$intit_question = "";
				$nbq = 0;

				echo "<form method=\"POST\" action=\"#\">";

				$donnees = $reponse->fetch();

				//var_dump($donnees);
				if ($donnees != false) {

					echo "<input type=\"hidden\" name=\"Titreq\" value=\"".$donnees["Id"]."\"/>";

					echo "<h2>".$donnees['Titre']."</h2>"; //Affichage du titre

					echo "<p>";
					// $intit_question = $donnees['Intitule']; //affichage 1ere question
					$intit_question = "";

					$nbq++;

					$num_rep = 1;

					echo "<input type=\"hidden\" name=\"Numq".$nbq."\" value=\"".$donnees['Num_q']."\"/>";

					do {

						if ($intit_question != $donnees['Intitule']) {
							$nbq++;
							$num_rep = 1;
							echo "<input type=\"hidden\" name=\"Numq".$nbq."\" value=\"".$donnees['Num_q']."\"/>";
							$intit_question = $donnees['Intitule'];
							echo "</p>"; //on sort de la question précédente
							echo "<h5>".$donnees['Intitule']."</h5>"; //Affichage de la question
							echo "<p>";
						}

						echo $donnees['Intitule_r']; //affichage de la réponse
						if ($donnees['Type'] == 1) { //ajouter un bouton radio
							echo "<input type=\"radio\" name=\"".$donnees['Num_q']."\" value=\"".$donnees['rep_id']."\"";
						}
						else {
							echo "<input type=\"checkbox\" name=\"".$donnees['Num_q']."+".$num_rep."\" value=\"".$donnees['rep_id']."\"";
							$num_rep++;
						}

						echo "<br/>";
					
					}while($donnees = $reponse->fetch());

					echo "</p>";

					echo "<input type=\"hidden\" name=\"Nbq\" value=\"".$nbq."\"/>"; //nombre de questions

					echo "<input type=\"submit\" value=\"Soumettre le questionnaire\" name=\"submit\"/>";

					echo "</form>";

					$reponse->closeCursor();
				}
				else { 
					header('Location: http://localhost/site_qcm');
				}
			} //end isset $_GET q
			else {
				header('Location: http://localhost/site_qcm');
			}
		?>

		<!--
			Requetes à la base de donnée;
		-->
	</div>

</body>

</html>
