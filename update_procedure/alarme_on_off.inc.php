<?php
if (($nom_switch[$j]==$telecommande_na) OR ($nom_switch[$j]==$telecommande_fr))
	{	
	if (strcmp ($etat_switch[$j],$etat_alarme_bdd) !== 0)
		{
			/*changer l'etat de l'autre switch*/
		if ($nom_switch[$j]==$telecommande_na)
			{
			$id_ch = $switch['id']-1;
			}
		else
			{
			$id_ch = $switch['id']+1;
			}

		if ($etat_switch[$j] == 'on')
			{
			$retour = @file_get_contents($base_url.'/sw/'.$id_ch.'/on');
			$etat_bdd_switch[$id_ch] = $etat_switch[$j];
			}
		else
			{
			$retour = @file_get_contents($base_url.'/sw/'.$id_ch.'/off');
			$etat_bdd_switch[$id_ch] = $etat_switch[$j];
			}
/*mettre a jour la bdd*/
		$etat_bdd_switch[$j] = $etat_switch[$j];
		$etat_alarme_bdd = $etat_switch[$j];
		$alarme_armement = $etat_switch[$j];
		$update =  date("Y-m-d H:i:s");
		echo $update." alarme ".$alarme_armement."\n";
		$query=("INSERT INTO $table_histo (nom,etat) VALUES ('alarme','$etat_switch[$j]')");
		mysql_query($query) or die (mysql_error());	
		$query=("UPDATE $table SET etat='$etat_switch[$j]' WHERE nom LIKE '$switch[name]'");
		mysql_query($query) or die (mysql_error());		
		$query=("UPDATE $table SET etat='$etat_switch[$j]' WHERE nom LIKE 'alarme'");
		mysql_query($query) or die (mysql_error());
		
			if ($etat_alarme_bdd == 'on')
			{
				$preset=0;
			switch_preset($preset);
			$update =  date("Y-m-d H:i:s");
			echo $update." preset regle a 0\n";
			/*home*/
			}
			else
			{
				$preset=1;
			switch_preset($preset);
			echo $update." preset regle a 1\n";
			/*away*/
			}
		
		
		
		}
	}
	else
	{
		if ($etat_alarme_bdd == 'on')
			{
			if ($etat_switch[$j] == 'on')
				{
					/*if ($nom_switch[$j] Chauf
					$id_ch = $switch['id'];*/
					
					$retour = @file_get_contents($base_url.'/sw/'.$id_ch.'/off');
				}
			}
	}
?>