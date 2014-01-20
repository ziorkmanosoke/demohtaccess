
<?php 
include("haut.html"); 
include("fonctions.php");
#
# Cette page est appelée par tous les liens dans le site.
# Elle inclut le HTML de l'entête et du pied de page.
# Elle définit le contenu des 2 DIV dont le contenu change selon le 
# lien sélectionné par l'utilisateur. Il y a 3 cas possible:
# - Soit aucune variable n'est passée dans le lien, et on affiche les promotions;
# - Soit la variable "modele" est passée dans le lien et on affiche les détails d'un modèle;
# - Soit la variable "categ" est passée dans le lien et on affiche la liste des modèles de la catégorie;

# Les fonctions promos(), infos_modele() et liste_modeles() génèrent le code HTML correspondant
# qui est ensuite inséré dans le DIV "main".

# Dans tous les cas, le DIV "gauche" contient la liste des catégories
$menu_gauche = liste_cat();

if (!isset($_GET['categ']) and !isset($_GET['modele'])) {
	# Si ni "modele" ni "categ" ne sont définies, faire la liste des promotions
	$contenu = promos();
	
}	
elseif(isset($_GET['modele'])) {
	# Si "modele" est défini, on affiche les informations sur le modèle
	$contenu = infos_modele($_GET['modele']);

}
elseif(isset($_GET['categ'])) {
	# Si "categ" est défini, on affiche la liste des modèles correspondants
	$contenu = liste_modeles($_GET['categ']);
}

echo "<div id=\"gauche\">$menu_gauche</div><div id=\"main\">$contenu</div>";
	
include "bas.html" ?>
