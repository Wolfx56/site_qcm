<?php

function auth_cas($url)
{
	require_once('CAS-1.3.3/CAS.php');

	$url_serveur_cas="cas.unilim.fr";
	$port_cas=443;

	phpCAS::setDebug();

	// initialize phpCAS
	phpCAS::client(CAS_VERSION_2_0,$url_serveur_cas,$port_cas,'cas');


	//phpCAS::setNoCasServerValidation();
	phpCAS::setNoCasServerValidation();

	echo "Oui";


	//$auth = @phpCAS::checkAuthentication();

	echo "Non";

	//if (!$auth) {
		@phpCAS::forceAuthentication();
	//}

	if (isset($_REQUEST['logout'])) {
		//@phpCAS::logout(array('url'=>'web5.unilim.fr/tutorat-test'));
		@phpCAS::logout($url);
	}

	echo "Non2";

	$login= @phpCAS::getUser();

	return $login;
}


function recupInfosLdap($login)
{
	$url_serveur_ldap = "ldap.unilim.fr";
	$port="389";
	$basedn="ou=people,dc=unilim,dc=fr";
	$ds = ldap_connect($url_serveur_ldap,$port); 

	if ($ds) {
		ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);
		$r=ldap_bind($ds);
		if (!$r ) {
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

?>