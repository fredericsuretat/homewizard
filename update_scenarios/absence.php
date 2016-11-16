<?php
if ($etat_alarme_bdd == "on"):
{
	
	if ($contact_V[$porte_entree]['status'] == 'yes'):/*PORTE OUVERTE*/
		{
		if ($alarme_armement == "off"):	
			{
			/*echo "porte ouverte mais alarme desactivee\n";*/
			}
		else :
			{
				/*porte entrée Ouverte armement à on*/
			$update =  date("Y-m-d H:i:s");
/*ideal : SMS($phone_user_fred,$phone_pass_fred)*/
			echo $update." alarme declenchee, SMS envoye aux utilisateurs\n";
			$n=0;
			foreach($user_SMS as $n => $sms_to_send)
			{
				$phone_nom = $user_SMS[$n]['nom'];
				$phone_user = $user_SMS[$n]['user'];
				$phone_pass = $user_SMS[$n]['pass'];
				$message = $phone_nom."%20la%20porte%20est%20ouverte%20avec%20alarme%20en%20route%20!";
				include('SMS.inc.php');
				$n++;
			}
			
			
			$query=("INSERT INTO $table_histo (nom,etat) VALUES ('alarme_armement','$alarme_armement')");
			mysql_query($query) or die (mysql_error());	
			$query=("UPDATE $table SET etat='$alarme_armement' WHERE nom LIKE 'alarme_armement'");
			mysql_query($query) or die (mysql_error());
			$alarme_armement = "off";
			$alarme_use = "on";
			}
		endif;
		}
	else :
		{
			/*porte fermée mais alarme activée à la suite d'une alarme -> desarmement de l'alarme prete pour une nouvelle activation*/	
		if ($alarme_use == "on"):	
			{
			$update =  date("Y-m-d H:i:s");
			echo $update." fin d'alerte\n";
				/*désarmer l'alarme*/
			$alarme_use = "off";
			$alarme_armement = "on";
			}
		else :
			{
				/*porte fermée, alarme activée mais armement à on tout est OK*/
				$alarme_armement = "on";
			}
		endif;		
		}
	endif;
	
}
else:
{
	/*Alarme à OFF peut importe l'etat de la porte*/
	$alarme_armement = "off";
	if ($contact_V[$porte_entree]['change'] == 'yes'):
		{
		if ($contact_V[$porte_entree]['status'] == 'yes'):
			{
				echo $update."la porte vient de s'ouvrir\n";
				
				if ($switch_V[$lumiere_canap]['status'] =='no');
				{
				 	$retour = @file_get_contents($base_url.'/sw/'.$switch_V[$lumiere_canap]['id'].'/on');
				 	$objet=$switch_V[$lumiere_canap]['id'];
					$etat_souhaite='off';
					$now = date("Y/m/d H:i:s", strtotime("now"));
					$horodatage = date("Y-m-d H:i:s", strtotime('+3 minutes',strtotime($now)));
				 	$query=("INSERT INTO $table_action_prog (objet,etat_souhaite,horodatage) VALUE('$objet', '$etat_souhaite', '$horodatage')");
					mysql_query($query) or die (mysql_error());
					$update =  date("Y-m-d H:i:s");
					echo $update." lumiere allumee et extinction programmee à ".$horodatage."\n";
				}
				/*recupérer l'etat de la lumiere du canap*/
				/*si celle-ci était allumée la laisser allumée et ne rien programmer*/
				/*si la lumière du canap était éteinte, l'allumer et programmer son extinction*/
			}
		else:
			{
				$update =  date("Y-m-d H:i:s");
				echo $update." la porte vient de se fermer\n";
			}
		endif;
		}
	else :
		{
		}
	endif;
	
	
	
}
endif;

$query=("UPDATE $table_scenario set time_updated=now() WHERE nom LIKE '$nom_scenarios[$m]'");
mysql_query($query) or die (mysql_error());

?>