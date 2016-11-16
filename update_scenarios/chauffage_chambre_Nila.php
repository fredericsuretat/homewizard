<?php
$update =  date("Y-m-d H:i:s");
/*scénario Chauffage Nila*/
/*
$porte_chambre_Nila ="porteChambrefon" ;
$chaffage_chambre_Nila ="Chauf ch fond" ;
thermo 'chambrefond'
*/
/*verifier l'etat souhaité stocké en bdd*/
if ($contact_V[$porte_chambre_Nila]['status']=="no"):
	if (floatval($etat_thermo['chambrefond'])>floatval($temperature_chambre_max)):
		if ($switch_V[$chaffage_chambre_Nila]['status']=="on"):
			$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chaffage_chambre_Nila]['id'].'/off');
			echo $update." chauffage eteint, trop chaud ".$switch_V[$chaffage_chambre_Nila]['id']." off\n";
			
			$message = "le chauffage de la chambre de Nila a ete eteint car le chauffage est ".$switch_V[$chaffage_chambre_Nila]['status']."\r\n et que la temperature de la chambre a atteint ".$etat_thermo['chambrefond']." (la température max definie est de ".$temperature_chambre_max." degres.)";
			$subject = 'Add_event - chauffage Nila';
			envoi_mail($subject,$message);
			
			
		endif;
	else:
			if((floatval($etat_thermo['chambrefond']) === NULL) || (is_null(floatval($etat_thermo['chambrefond'])))):
				$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chaffage_chambre_Nila]['id'].'/off');
				echo $update." chauffage eteint par sécurité car la temperature ne remonte pas ".$switch_V[$chaffage_chambre_Nila]['id']." off\n";
			/*test*/
			// Le message
			$message = "le chauffage de la chambre de Nila a ete eteint car le chauffage est ".$switch_V[$chaffage_chambre_Nila]['status']." par sécurité car la temperature ne remonte pas.";
			$subject = 'Add_event - chauffage Nila';
			envoi_mail($subject,$message);			
					
			endif;
			
			if (floatval($etat_thermo['chambrefond'])<floatval($temperature_chambre_min)):
				if ($switch_V[$chaffage_chambre_Nila]['status']=="off"):
				$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chaffage_chambre_Nila]['id'].'/on');
				echo $update." chauffage eteint, trop chaud ".$switch_V[$chaffage_chambre_Nila]['id']." on\n";
			
				/*test*/
				// Le message
				$message = "le chauffage de la chambre de Nila a ete a ete allume car le chauffage est ".$switch_V[$chaffage_chambre_Nila]['status']."\r\n et que la temperature de la chambre a atteint ".$etat_thermo['chambrefond']." (la température min definie est de ".$temperature_chambre_min." degres.)";
				$subject = 'Add_event - chauffage Nila';
				envoi_mail($subject,$message);
				endif;	
			
			endif;
			
			
	endif;	
else:
	/*si la porte est ouverte et si le chauffage est allumé*/	
		if ($contact_V[$porte_chambre_Nila]['status']=="yes"):
			if ($switch_V[$chaffage_chambre_Nila]['status']=="on"):
		 		$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$chaffage_chambre_Nila]['id'].'/off');
				echo $update." chauffage chambre Nila eteint car ".$nom_kaku[$porte_chambre_Nila]." ouverte \n";


		 	endif;
		 endif;
endif;

$query=("UPDATE $table_scenario set time_updated=now() WHERE nom LIKE '$nom_scenarios[$m]'");
mysql_query($query) or die (mysql_error());
?>