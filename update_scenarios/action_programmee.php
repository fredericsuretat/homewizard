<?php

$query=("SELECT num, objet, etat_souhaite, horodatage, fait FROM action_programmee where `horodatage` < NOW()");
$action = mysql_query($query) or die (mysql_error());

while ($actions = mysql_fetch_array($action)){
/*echo "numero de l'action : ".$actions['0']." objet actionne".$actions['1']." etat souhaite :".$actions['2']." horodatage : ".$actions['3']." etat (fait ?) ".$actions['4']."<BR>";*/
	if ($actions['4'] == ""):/*action non faite*/
		{
			$retour = @file_get_contents($base_url.'/sw/'.$actions['1'].'/'.$actions['2']);
			$num_action=$actions['0'];
			$query=("UPDATE $table_action_prog SET `fait`=NOW() WHERE `num` LIKE '$num_action'");
			mysql_query($query) or die (mysql_error());
			$query=("UPDATE $table_scenario set time_updated=now() WHERE nom LIKE '$nom_scenarios[$m]'");
			mysql_query($query) or die (mysql_error());
			echo $update." action programmée ".$switch_V[$actions['1']]['name']." passé à ".$actions['2']." \n";
			echo $update." http://".$ip_serv."/**********/sw/".$actions['1']."/".$actions['2']."\n";
		}
	else:
		{
			/*echo "action deja faite";*/
		}
	endif;
/*
pour remplacer le echo
$retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd.'/sw/'.$actions['1'].'/'.$actions['2']);
*/


}

?>