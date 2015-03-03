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

	if (!isset($_SESSION['Admin']) || $_SESSION['Admin'] != 1) {
		header("Location: http://localhost/site_qcm/index.php");
		exit();
	}

	//var_dump($_SESSION);

	require_once("connexion_bd.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Page Perso</title>
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
				echo "Bienvenue Maitre $_SESSION[prenom]";
				echo '</span>';
				
				echo '<a class="lien_connexion" href="http://localhost/site_qcm/Site_Qcm.php?logout=true">Deconnexion</a>';
			?>
		</div>
	</div>

	<div id="page">

		<?php
			$query = "SELECT * FROM identifiant WHERE Nom != \"".$_SESSION['nom']."\"";
			//echo "$query";
			$requete = $bdd->query($query);

			echo "<table>";
			echo "<thead>";
		    	echo "<tr>";
           			echo"<th>Nom</th>";
           			echo "<th>Prenom</th>";
           			echo "<th>Statut</th>";
 					echo "<th>Admin</th>";
 					echo "<th>Supprimer</th>";
				echo "</tr>";
   			echo "</thead>";

   			echo "<tbody>";

			while ($donnee = $requete->fetch()) {
				//var_dump($donnee);
				echo "<tr>";
					echo "<td>".$donnee['Nom']."</td>";
					echo "<td>".$donnee['Prenom']."</td>";
					echo "<td>".$donnee['Statut']."</td>";
					if ($donnee['Admin'] == 1)
						echo "<td>X</td>";
					else 
						echo "<td></td>";
					echo "<td><img src=\"./images/del.png\"/ style=\"width:20px; height:20px;\"></td>";
				echo "</tr>";	
			}
			echo "</tbody>";
			echo "</table>";

		?>	
	</div>
</body>

</html>