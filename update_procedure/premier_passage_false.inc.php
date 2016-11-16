<?php

	sleep(1);
	echo "\n".$maintenant." echec initialisation\n";
    $error = error_get_last();
    /*log*/
	$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'recup', 'init - recupération impossible')");
	mysql_query($query) or die (mysql_error());
	$query=("UPDATE $table SET etat='KO' WHERE nom LIKE 'etat_box_domotique'");
	mysql_query($query) or die (mysql_error());
	$json = file_get_contents($jsonurl);
?>