<?php
$k=0;
if (is_array($kaku))
{
	foreach($kaku as $contact){
		$nom_kaku[$k] = $contact['name'];
		$etat_kaku[$k] = $contact['status'];
		$contact_V[$contact['name']]['id']= $contact['id'];
		$contact_V[$contact['name']]['status']= $contact['status'];
		$contact_V[$contact['name']]['change']= "no";
		$contact_V[$contact['id']]['name']=$contact['name'];
		$contact_V[$contact['id']]['status']=$contact['status'];
		
			if(!empty($etat_kaku[$k]))
			{
				if (strcmp ($etat_kaku[$k],$etat_bdd_kaku[$k]) !== 0)
				{
					/*echo "mise a jour contact<br>";*/
					$contact_V[$contact['name']]['change']= "yes";
					$etat_bdd_kaku[$k] = $etat_kaku[$k];	
					$query=("INSERT INTO $table_histo (nom,etat) VALUES ('$contact[name]','$etat_kaku[$k]')");
					mysql_query($query) or die (mysql_error());
					$query=("UPDATE $table SET etat='$etat_kaku[$k]' WHERE nom LIKE '$contact[name]'");
					mysql_query($query) or die (mysql_error());
					$update =  date("Y-m-d H:i:s");
					/*log*/
					$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'change', '$contact[name] etat : $etat_kaku[$k]')");
					mysql_query($query) or die (mysql_error());
					/*/log*/
					echo $update." ".$nom_kaku[$k]." ".$etat_kaku[$k]." \n";
					notif_porte($nom_kaku[$k],$porte_entree,$etat_kaku[$k]);
				}
			/*echo "contact ".$contact['name']." etat reel : ".$etat_kaku[$k]." etat en base : ".$etat_bdd_kaku[$k]."<BR>";*/
			}
	$k++;		
	}
}
?>