<?php
$l=0;
if (is_array($thermo))
{
	foreach($thermo as $thermometers){
	$nom_thermo[$l] =  $thermometers['name'];
	$etat_thermo[$l] =  $thermometers['te'];
	$etat_thermo[$nom_thermo[$l]] = $thermometers['te'];
		if(!empty($etat_thermo[$l]))
		{
			if (strcmp ($etat_thermo[$l],
			$etat_bdd_thermo[$l]) !== 0)
			{
			/*echo "mise a jour thermo<br>";*/
				$etat_bdd_thermo[$l] = $etat_thermo[$l];
				$query=("INSERT INTO $table_histo (nom,etat) VALUES ('$thermometers[name]','$etat_thermo[$l]')");
				mysql_query($query) or die (mysql_error());
				$query=("UPDATE $table SET etat='$etat_thermo[$l]' WHERE nom LIKE '$thermometers[name]'");
				mysql_query($query) or die (mysql_error());
			}
					/*echo "thermo ".$thermometers['name']." etat reel : ".$etat_thermo[$l]." etat en base : ".$etat_bdd_thermo[$l]."<BR>";*/

		}
	$l++;
	}
}
?>