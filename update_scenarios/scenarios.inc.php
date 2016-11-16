<?php
/*scénarios*/
$query=("SELECT nom,etat FROM $table_scenario");
$res =mysql_query($query) or die (mysql_error());
$m=1;
while($rows = mysql_fetch_array($res))
	{
	$nom_scenarios[] = $rows['nom'];
	$etat_scenarios[] = $rows['etat'];
	if (strcmp ($etat_scenarios[$m],"on") ==0)
		 	{
				include($nom_scenarios[$m].'.php');
		 	}
	$m++;
	}
/*fin scénarios*/
$min = "/".date("i:s", strtotime("now"))."/";
$count_passages++;
?>