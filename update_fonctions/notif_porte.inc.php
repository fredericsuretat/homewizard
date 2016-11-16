<?php
function notif_porte($nom_kak,$item_comp,$etat_kak)
{
					if (strncmp($item_comp,$nom_kak,strlen($item_comp))==0)
						{
							if (strncmp($etat_kak,"yes",3)==0)
							{
								$etat_modif = "ouverte";
							}
							if (strncmp($etat_kak,"no",2)==0)
							{
								$etat_modif = "fermee";
							}
								$message = $nom_kak."  est ".$etat_modif.".";
								$subject = 'Add_event - '.$nom_kak.' est '.$etat_modif;
								envoi_mail($subject,$message);
							
						/*ici rÃ©cupÃ©rer l'etat de la lumiÃ¨re du canapÃ©, l'alumer (si ce n'est pas fait) et programmer l'extinction (prÃ©voir que Ã§a s'Ã©teinge dans ce cas uniquement si l'alarme est mise))*/
						}	
}
?>