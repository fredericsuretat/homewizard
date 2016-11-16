<?php
$update =  date("Y-m-d H:i:s");
/*scénario Chauffage chNF*/
/*echo $update." chauffage : ".$switch_V['Chauffage chNF']['id']." ".$switch_V['Chauffage chNF']['status']." porte chambre :".$contact_V['Porte chambre']['id']." ".$contact_V['Porte chambre']['status']."\n";*/

/*verifier l'etat souhaité stocké en bdd*/
if ($contact_V[$porte_chambre]['status']=="no"):
	/*verifier l'etat en réel du chaffage (eteint)*/
	/*echo "<UL>";
	echo "<LI>le chauffage est eteint</LI>";*/
	if (floatval($etat_thermo['Chambre'])>floatval($temperature_chambre_max)):
		if ($switch_V[$chauffage_chambre_NF]['status']=="on"):
			$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chauffage_chambre_NF]['id'].'/off');
			echo $update." chauffage eteint, trop chaud ".$switch_V[$chauffage_chambre_NF]['id']." off\n";
		endif;
	else:
		/*	echo "<LI>la temp est inf a 18 il faudrait l'activer</LI>";
		echo "<LI>".$nom_kaku[1]." ". $etat_kaku[1]."</LI>";*/
	endif;	
else:
	/*si le chauffage est allumé*/	
		if ($contact_V[$porte_chambre]['status']=="yes"):
			/*echo " c'est activé <BR>";*/	
			/*si la porte est ouverte*/
			if ($switch_V[$chauffage_chambre_NF]['status']=="on"):
		 		$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chauffage_chambre_NF]['id'].'/off');
				echo $update." chauffage eteint car ".$nom_kaku[$porte_chambre]." ouverte \n";


		 	endif;
		 endif;
endif;

$query=("UPDATE $table_scenario set time_updated=now() WHERE nom LIKE '$nom_scenarios[$m]'");
mysql_query($query) or die (mysql_error());
?>