<!--
Appel
$login = auth_cas("http://blabla");

Retourne le login de la personne connectée
Pour la déconnexion il suffit d'appeler une page où cette fonction est
appelée et passer en get logout=y ; par exemple
http://www.blabla.fr/?logout=y
A la deconnexion, on est redirigé vers la page passée en argument de
auth_cas()

Appel
$info = $infoLdap($login);
Retourne un tableau qui contient le nom, le prénom et le mail .
-->

<?php
	function auth_cas($url) {
		include_once('CAS-1.3.3/CAS.php');

		$url_serveur_cas="cas.unilim.fr";
		$port_cas=443;

			// initialize phpCAS
		phpCAS::client(CAS_VERSION_2_0,$url_serveur_cas,$port_cas,'cas');
		//phpCAS::setLang('french');

		if (isset($_REQUEST['logout']))
		{
			//@phpCAS::logout(array('url'=>'web5.unilim.fr/tutorat-test'));
			@phpCAS::logoutWithUrl($url);
		}
		
		@phpCAS::setNoCasServerValidation();
		$auth = @phpCAS::checkAuthentication();
		if (!$auth)
		{
			@phpCAS::forceAuthentication();
		}

		$login= @phpCAS::getUser();

		return $login;
	}

	function recupInfosLdap($login) {
		$url_serveur_ldap = "ldap.unilim.fr";
		$port="389";
		$basedn="ou=people,dc=unilim,dc=fr";
		$ds=ldap_connect($url_serveur_ldap,$port); // Doit être un serveur LDAP valide!

		if ($ds)
		{
			ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);
			$r=ldap_bind($ds);
	
			if (!$r )
			{
				ldap_close($ds);
				exit;
			}
			else
			{
				$sr=ldap_search($ds,$basedn, "uid=$login");
				$info = ldap_get_entries($ds, $sr);
				ldap_close($ds);

				$infoLdap["nom"]=$info[0]["sn"][0];
				$infoLdap["prenom"]=$info[0]["givenname"][0];
				$infoLdap["courriel"]=$info[0]["mail"][0];
			}
		}
		return $infoLdap;
	}

	function authentification($login) {
		require_once('./connexion_bd.php');

		//On regarde si le login de la personne qui s'authentifie est connue de la base de donnée en récupérant son ID
		$requete = "SELECT ID FROM identifiant WHERE Login = \"$login\"";
		$resultat = $bdd->query($requete);
		$ligne = $resultat->fetch();
		$resultat->closeCursor();

		//var_dump($ligne);

		//Si le login n'est pas connu, alors on ajoute la personne dans la base de donnée
		if ($ligne[0] == 0) {
			$info = recupInfosLdap($login);

			$req = $bdd->prepare("INSERT INTO identifiant(Login,Prenom,Nom,Statut,Admin) VALUES (:log, :prenom, :nom, :state, :ad)");

			if (preg_match('#@etu.unilim.fr#',$info['courriel']) == 1) {
				$req->execute(array(
					'log' 		=> $login, 
					'prenom'	=> $info['prenom'],
					'nom'		=> $info['nom'],
					'state'		=> "Etudiant",
					'ad'		=> 0
				));
			}
			else {
				$req->execute(array(
					'log' 		=> $login, 
					'prenom'	=> $info['prenom'],
					'nom'		=> $info['nom'],
					'state'		=> "Professeur",
					'ad'		=> 0
				));
			}
		}
	}
?>