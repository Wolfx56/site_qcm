<!DOCTYPE html>

<?php
	session_start();
	
	require_once("./fonctions.php");
	//require_once("./connexion_bd.php");

	if (isset($_GET['authCAS']) || isset($_GET['logout'])) {
		
		$url = "http://localhost/site_qcm/index.php";
		$log = auth_cas($url);
		$info = recupInfosLdap($log);

		$_SESSION['nom'] = $info['nom'];
		$_SESSION['prenom'] = $info['prenom'];

		$query = "SELECT Admin,Statut FROM identifiant WHERE Nom = \"".$_SESSION['nom']."\"";

		require_once("./connexion_bd.php");

		$reponse = $bdd->query($query);
		$res = $reponse->fetch();
		var_dump($res);
		$_SESSION['Admin'] = $res['Admin'];
		$_SESSION['Statut'] = $res['Statut'];
		
		header('Location: index.php');
		exit();
	}

?>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
        <title>BOUCHERY QCM - Travailler avec vos QCMs en toute simplicité</title>
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
					if (!isset($_SESSION['nom']) || $_SESSION['nom'] == '') {
						echo '<a class="lien_connexion" href="http://localhost/site_qcm/index.php?authCAS=CAS">Connexion</a>';
					}
					else {

						$login = $_SESSION['phpCAS']['user'];
						echo '<span class="espacement">';
						echo "Bienvenue ".ucfirst (strtolower($_SESSION['prenom']))." $_SESSION[nom]";
						echo '</span>';

						authentification($login);
						
						echo '<a class="lien_connexion" href="http://localhost/site_qcm/index.php?logout=true">Deconnexion</a>';
					}
				?>
			</div>
		</div> <!-- end div banniere_haut -->

		<?php
			if(isset($_SESSION['nom'])) {
		?>
				<nav id="menu">
			<?php
					if (isset($_SESSION['Statut']) && $_SESSION['Statut'] == "Professeur") {
						echo "<ul>";
							echo "<li><a href=\"http://localhost/site_qcm/site_Qcm.php\">Créer un questionnaire</a></li>";
							echo "<li><a href=\"http://localhost/site_qcm/consultation_qcm.php\">Consulter la liste des questionnaires</a></li>"; //page a faire
						echo "</ul>";
					}
		?>
				</nav>
		<?php
			}
		?>

		<div id="page">
			<h1>Bienvenue sur BOUCHERY QCM !</h1>
			<?php
				if(!isset($_SESSION['nom'])) {
					echo '<p>Blabla de page d\'acceuil</p>';
				}
				else {
					var_dump($_SESSION);
					echo '<p>blabla des optiosn présentes pour les utilisateurs. Il y a deux types d\'utilisateurs : les étudiants et les professeurs. <br/>
					Les professeurs peuvent créer des qcms, les rendrent visibles pour les élèves, <br/>
					Les étudiants peuvent consulter leurs qcms, y répondrent et obtenir une note, voir les qcms liés aux professeurs, demander une liaison</p>';
				}
			?>
		</div>
	</body>
</html>