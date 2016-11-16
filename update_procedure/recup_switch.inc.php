<?php
$j=0;
if (is_array($switches))
{
	foreach ($switches as $switch){
			$id = $switch['id'];
			$nom_switch[$j] = $switch['name'];
			$etat_switch[$j] = $switch['status'];
			$switch_V[$switch['name']]['id']= $switch['id'];
			$switch_V[$switch['name']]['status']= $switch['status'];
			$switch_V[$switch['name']]['change']= "no";
			$switch_V[$switch['id']]['name']=$switch['name'];
			$switch_V[$switch['id']]['status']=$switch['status'];
			
			if(!empty($etat_switch[$j]))
				{
					/*echo "switch ".$switch['name']." etat reel : ".$etat_switch[$j]." etat en base : ".$etat_bdd_switch[$j]."<BR>";*/
				include('alarme_on_off.inc.php');
				
				if (strcmp ($etat_switch[$j],$etat_bdd_switch[$j]) !== 0)
					{
						/*echo "mise a jour switch<br>";*/
						$query=("INSERT INTO $table_histo (nom,etat) VALUES ('$switch[name]','$etat_switch[$j]')");
						mysql_query($query) or die (mysql_error());	
						$query=("UPDATE $table SET etat='$etat_switch[$j]' WHERE nom LIKE '$switch[name]'");
						mysql_query($query) or die (mysql_error());
						$update =  date("Y-m-d H:i:s");
						echo $update." ".$nom_switch[$j]." ".$etat_switch[$j]."\n";
						$switch_V[$switch['name']]['change']= "yes";
						$etat_bdd_switch[$j] = $etat_switch[$j];
						/*log*/
						$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'change', '$switch[name] etat : $etat_switch[$j]')");
						mysql_query($query) or die (mysql_error());
						/*/log*/
					}							

					$j++;
			}
	}
}
?>