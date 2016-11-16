<?php
	echo "\n".$maintenant." initialisation OK\n";
    /*log*/
	$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'script', '$maintenant initialisation OK')");
	mysql_query($query) or die (mysql_error());
	/*/log*/
	$data = json_decode($json,true);
	$query=("UPDATE $table SET etat='OK' WHERE nom LIKE 'etat_box_domotique'");
	mysql_query($query) or die (mysql_error());
	$switches =  $data['response']['switches'];
	$thermo = $data['response']['thermometers'];
	$kaku = $data['response']['kakusensors'];
	/*
	récupération des valeurs en base de donnée
	*/
	$query=("SELECT etat FROM $table_histo where nom='alarme' ORDER BY horodatage DESC  limit 0,1");
	$row = mysql_fetch_row(mysql_query($query));
	$etat_alarme_bdd = $row[0];
	$query=("SELECT etat FROM $table_histo where nom='alarme_armement' ORDER BY horodatage DESC  limit 0,1");
	$row = mysql_fetch_row(mysql_query($query));
	$alarme_armement = $row[0];
	$j=0;
	if (is_array($switches))
	{
	foreach ($switches as $j => $switch)
		{
		$nom_switch[$j] = $switch['name'];
		$etat_switch[$j] = $switch['status'];
		$switch_V[$switch['name']]['id']= $switch['id'];
		$switch_V[$switch['name']]['status']= $switch['status'];
		$switch_V[$switch['id']]['name']=$switch['name'];
		$switch_V[$switch['id']]['status']=$switch['status'];
		$query=("SELECT etat FROM $table_histo where nom='$nom_switch[$j]' ORDER BY horodatage DESC  limit 0,1");
		$row = mysql_fetch_row(mysql_query($query));
		$etat_bdd_switch[$j] = $row[0];
		/*le bloc suivant sert à créer l'entrée dans la base si elle existe pas.*/
		$query=("SELECT nom FROM $table WHERE nom='$nom_switch[$j]'");
		$row = mysql_fetch_row(mysql_query($query));
		$nom_bdd_switch[$j] = $row[0];
		if (empty($nom_bdd_switch[$j]))
			{
			$query=("INSERT INTO $table (nom,etat) VALUES ('$switch[name]','$etat_switch[$j]')");
			mysql_query($query) or die (mysql_error());
			echo "<br/>".$query."<br/>";
			/*log*/
			$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'ajout', 'ajout de l item suivant  : $switch[name] etat : $etat_switch[$j]')");
			mysql_query($query) or die (mysql_error());
			/*log*/
			}
		$j ++;
		}
	}
	$k=0;
	if (is_array($kaku))
	{
	foreach($kaku as $k => $contact)
		{
		$nom_kaku[$k] = $contact['name'];
		$etat_kaku[$k] = $contact['status'];
		$contact_V[$contact['name']]['id']= $contact['id'];
		$contact_V[$contact['name']]['status']= $contact['status'];
		$contact_V[$contact['id']]['name']=$contact['name'];
		$contact_V[$contact['id']]['status']=$contact['status'];
		$query=("SELECT etat FROM $table_histo where nom='$nom_kaku[$k]' ORDER BY horodatage DESC  limit 0,1");
		$row = mysql_fetch_row(mysql_query($query));
		$etat_bdd_kaku[$k] = $row[0];
		$query=("SELECT nom FROM $table WHERE nom='$nom_kaku[$k]'");
		$row = mysql_fetch_row(mysql_query($query));
		$nom_bdd_kaku[$k] = $row[0];
		if (empty($nom_bdd_kaku[$k]))
			{
			$query=("INSERT INTO $table (nom,etat) VALUES ('$nom_kaku[$k]','$etat_kaku[$k]')");
			mysql_query($query) or die (mysql_error());
			echo "<br/>".$query."<br/>";
			/*log*/
			$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'ajout', 'ajout de l item suivant  : $nom_kaku[$k] etat : $etat_kaku[$k]')");
			mysql_query($query) or die (mysql_error());
			/*/log*/
			/*mail en cas de changement d'etat*/
			notif_porte($nom_kaku[$k],$porte_entree,$etat_kaku[$k]);	
			}
		$k ++;
		}
	}
$l=0;
	if (is_array($thermo))
	{
	foreach($thermo as $l => $thermometers)
		{
		$nom_thermo[$l] = $thermometers['name'];
		$etat_thermo[$l] =  $thermometers['te'];
		$etat_thermo[$nom_thermo[$l]] = $thermometers['te'];
		$query=("SELECT etat FROM $table_histo where nom='$nom_thermo[$l]' ORDER BY horodatage DESC  limit 0,1");
		$row = mysql_fetch_row(mysql_query($query));
		$etat_bdd_thermo[$l] = $row[0];
		$query=("SELECT nom FROM $table WHERE nom='$nom_thermo[$l]'");
		$row = mysql_fetch_row(mysql_query($query));
		$nom_bdd_thermo[$l] = $row[0];
		if (empty($nom_bdd_thermo[$l]))
			{
			$query=("INSERT INTO $table (nom,etat) VALUES ('$nom_thermo[$l]','$etat_thermo[$l]')");
			mysql_query($query) or die (mysql_error());
			echo "<br/>".$query."<br/>";
			/*log*/
			$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'ajout', 'ajout de l item suivant  :$nom_thermo[$l] etat : $etat_thermo[$l]')");
			mysql_query($query) or die (mysql_error());
			/*/log*/
			}
			$l ++;
		}
	}
	sleep(1);
	$maintenant = date("Y-m-d H:i:s");
	echo "\n".$maintenant." fin initialisation\n";
?>