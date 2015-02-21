<?php

	session_start();

	require_once("connexion_bd.php");

	// vérifier que le questionnaire n'existe pas déja
	$req_nb_quest = " SELECT Count(*) FROM questionnaire WHERE Titre = 'Mon deuxieme questionnaire' AND Login = 'bourrat02' ";
	$rep_nb_quest = $bdd->query($req_nb_quest);
	$nb_quest = $rep_nb_quest ->fetch();
	$rep_nb_quest->closeCursor();

	if (isset($_POST['val']) && $nb_quest[0] == 0) {

		$cpt = 1; //compteur de question
		$cpt_2 = 1; //compteur de num réponses possible
		$cpt_element = 0; //compte tous les éléments trouvés
		$cpt_rep = 1; //compteur de réponse trouvé
		$nbq = 0; //compteur de questions trouvées
		$max = count($_POST); //max recoit le nombre d'éléments dans le tableau

		$titre_qcm = $_POST['titre'];
		$login = $_SESSION['phpCAS']['user'];

		//ajout du questionnaire dans la base de donnée
		$bdd->exec("INSERT INTO questionnaire(Id,Titre,Login) VALUES('',\"$titre_qcm\", \"$login\")");

		// récupération du numéro de questionnaire
		$req_quest = "SELECT Id FROM questionnaire WHERE Titre = \"$titre_qcm\" AND Login = \"$login\"";
		$reponse = $bdd->query($req_quest);
		$donnees = $reponse->fetch();
		$reponse->closeCursor();

		$num_quest = $donnees['Id'];

		$codage = $login.$num_quest;
		$code = md5($codage);

		$ajout_code = $bdd->exec("UPDATE questionnaire SET Code = \"$code\" WHERE Id = $num_quest");

		/*Tant qu'on a pas pris en compte tous les éléments*/
		while ($cpt_element < $max - 2) { //on enleve le titre et le bouton envoyer

			$expr = "titreq".$cpt; //question définit comme ceci

			if (isset($_POST[$expr])) { //si la question existe
				$cpt_element += 2; // +2 pout l'intitulé de la question et le champ nb_reponses

				$reponse = "q".$cpt."nb_rep"; 
				$nb_rep = $_POST[$reponse]; //valeur du nombre de réponse de la question concernée

				$Intitule_q = $_POST[$expr]; 

				//ajout de la question dans la base de donnée
				$req_qu = $bdd->prepare('INSERT INTO question(Id,Intitule) VALUES(:Id,:Intitule)');
				$req_qu->execute(array(
				'Id' => $num_quest,
				'Intitule' => $Intitule_q,
				));

				//récupération numéro de la question
				$requete_numq = "SELECT Num_q FROM question WHERE Intitule = \"$Intitule_q\" AND Id = \"$num_quest\"";
				$response = $bdd->query($requete_numq);
				$donnees2 = $response->fetch();
				$response->closeCursor();

				$Num_q = $donnees2["Num_q"];

				/* recherche des réponses de la question enregistrée précédement */
				while ($cpt_rep <= $nb_rep) { //Tant que le compteur n'a pas atteint le nb de réponses a la question				
					$exprrep = 'rep'.$cpt.','.$cpt_2;

					if (isset($_POST[$exprrep])) { //la réponse existe
						// echo "$exprrep défini ???";
						$cpt_element++;

						$reponse_juste = $_POST[$exprrep];
						$reponse_q_u = "repq".$cpt;

						$juste = false; //initialisation si la réponse est juste ou non
						$Intitule_r = $_POST[$exprrep]; //intitulé de la réponse

						if (isset($_POST[$reponse_q_u])) { //la réponse unique							
							$type = 1;							

							if ($_POST[$reponse_q_u] == $exprrep) {
								$cpt_element++;
								$juste = true;
							}
						} 
						else { // réponse multiple
							$type = 2;

							$reponse_q_m = "rep".$cpt_2."q".$cpt;

							if (isset($_POST[$reponse_q_m])) {
								if ($_POST[$reponse_q_m] == $exprrep) {
									$juste = true;
									$cpt_element ++;
								}								
							}
						} // fin du else

						//enregistrement de la réponse
						$req_r = $bdd->prepare('INSERT INTO reponse(Num_q,Intitule_r,Juste) VALUES(:Num_q,:Intitule_r,:Juste)');
						$req_r->execute(array(
						'Num_q' => $Num_q,
						'Intitule_r' => $Intitule_r,
						'Juste' => $juste
						));

						//ajout du type(unique / multiple), maintenant qu'il est connu
						$nb_modifs = $bdd->exec("UPDATE question SET Type = \"$type\" WHERE Num_q = \"$Num_q\" AND Id = $num_quest");

						$cpt_rep++; //on incrémente le compteur de réponse trouves

					} //end if isset reponse

					$cpt_2++;

				} //end while reponse

				$cpt_2 = 1; //pour la question suivante
				$cpt_rep = 1; // 1 car la valeur de la reponse commence a 1
				$nb_rep = 0;

				$nbq++; //incrémentation nombre de questions
			}// end if isset question

			$cpt++;
		} // end while
	}

?>


<!DOCTYPE html>

<html>
	<head>
		<title>Test Site QCM</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>

		<script type="text/javascript" src="functions.js">
		</script>
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
				echo "<p> Enregistrement Réussi </p>";


			?>
		</div>

	</body>
</html>
