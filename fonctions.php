<?php

function connect() {
	# Se connecter à la BD sur le serveur, retourner la connexion

	$hote = "10.30.242.174";
	$usr = "mrbicycle";
	$psw = "abc-123";
	$bd = "mrbicycle";

	$cnn = mysql_connect($hote,$usr,$psw);
	if (!$cnn) {
		die('ERREUR DE CONNEXION : ' . mysql_error());
	} 
	
	mysql_select_db($bd);
	return $cnn;
}

function liste_cat() {

	# Générer le HTML qui contient la liste des catégories	

	# Connexion
	$cnn = connect();

	# Définir la requête et l'exécuter
	$req = "select id,nom from type_velo";	
	$resultat = mysql_query($req,$cnn);
	if (!$resultat) {
		$message  = 'REQUETE INVALIDE: ' . mysql_error() . "\n";
	}

	# $code est la variable qui contient le HTML; on ajoute un élément de la liste
	# pour chaque type de vélo dans la BD
	$code = "<ul>";
	
	while($r = mysql_fetch_array($resultat)) {
		$cat = $r['nom'];
		$id = $r['id'];
		$code = $code . "<li><a href=\"/demohtaccess/catalogue.php?categ=$id\">$cat</a></li>";
	}
	return $code;	
	
}


function infos_modele($modele) {

	# Définir une requête dont le filtre est l'ID de modèle passé
	$req = "SELECT modele.id as id, image,marque.nom as marque, modele.nom as modele, description,type_velo.id as idtype, type_velo.nom as type, prix 
	FROM modele 
	join marque on modele.id_marque = marque.id
	join type_velo on type_velo.id = modele.id_type
	WHERE modele.id = $modele";

	# Connexion, exécution de la requête
	$cnn = connect();
	$resultat = mysql_query($req,$cnn);

	if (!$resultat) {
		$message  = 'REQUETE INVALIDE: ' . mysql_error() . "\n";
	}
	
	# Extraire les données retournées par la requête, mettre dans des variables
	$r = mysql_fetch_array($resultat);
	$id = $r['id'];	
	$image = $r['image'];
	$marque = $r['marque'];
	$modele = $r['modele'];
	$description = $r['description'];
	$type = $r['type'];
	$idtype = $r['idtype'];
	$prix = $r['prix'];

	# Insérer les variables dans le code HTML
	$code = "<h2>$marque $modele</h2><h3>$type</h3>
		<img height=200px width=300px src='/demohtaccess/images/$image'><p>
		$description</p><h3>Prix : $prix</h3>
		<a href=/demohtaccess/catalogue.php?categ=$idtype>Retour &agrave; la liste</a>";

	return $code;
}

function promos() {

	# Définir une requête dont le filtre est l'ID de modèle passé
	$req = "SELECT modele.id as id, marque.nom as marque, modele.nom as modele, type_velo.nom as type, prix 
	FROM modele 
	join marque on modele.id_marque = marque.id
	join type_velo on type_velo.id = modele.id_type
	WHERE modele.promo = 1";

	# Connexion, exécution de la requête
	$cnn = connect();
	$resultat = mysql_query($req,$cnn);

	if (!$resultat) {
		$message  = 'REQUETE INVALIDE: ' . mysql_error() . "\n";
	}

	
	$code = "<h2>Promotions!</h2><ul>";
	
	while($r = mysql_fetch_array($resultat)) {

		# Extraire les données retournées par la requête, mettre dans des variables
		$id = $r['id'];	
		$marque = $r['marque'];
		$modele = $r['modele'];
		$type = $r['type'];
		$prix = $r['prix'];

		# Insérer les variables dans le code HTML
		$code = $code . "<li><a href=\"/demohtaccess/catalogue.php?modele=$id\">$marque $modele ($type) - $prix</a></li>";
	}

	return $code;
}

function liste_modeles($cat) {
	
	$req = "SELECT modele.id as id, image, marque.nom as marque, modele.nom as modele, prix 
	FROM modele 
	join marque on modele.id_marque = marque.id
	join type_velo on type_velo.id = modele.id_type
	WHERE modele.id_type = $cat";

	$cnn = connect();
	$resultat = mysql_query($req,$cnn);

	if (!$resultat) {
		$message  = 'REQUETE INVALIDE: ' . mysql_error() . "\n";
	}

	$code = "<ul>";
	
	while($r = mysql_fetch_array($resultat)) {
		$id = $r['id'];
		$image = $r['image'];		
		$marque = $r['marque'];
		$modele = $r['modele'];
		$prix = $r['prix'];
		$code = $code . "<li><a href=\"/demohtaccess/catalogue.php?modele=$id\"><img height=10% width=25% src='/demohtaccess/images/$image'></a>
				<a href=\"/demohtaccess/catalogue.php?modele=$id\">$marque $modele - $prix</a></li>";
	}

	return $code;

}
?>

