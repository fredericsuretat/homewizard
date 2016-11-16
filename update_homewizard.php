<?php
/*##################################################*/
/*
créer une tâche planifiée qui lance directement le fichier php.

/usr/bin/php -f/volume1/web/frederic/update_homewizard.php 
1>>/volume1/web/frederic/homewizard/out.txt 
2>>/volume1/web/frederic/homewizard/out.tx
pour un fonctionnement OK
première heure 00:00
toutes les 30 minutes
dernière heure : 23H30

*/
/*##################################################*/
$maintenant = date("Y-m-d H:i:s");
echo "\n".$maintenant." debut execution\n";
/*
déclaration des variables
*/
include('variable.inc.php');
include('homewizard/update_fonctions/mail.inc.php');
include('homewizard/update_fonctions/switch_preset.inc.php');
include('homewizard/update_fonctions/notif_porte.inc.php');
include('homewizard/update_fonctions/PID.inc.php');
/*
connection à la base de donnée
*/
$connexion = mysql_pconnect($hostname, $user, $passwd_homewizard) or die(mysql_error());
mysql_select_db($bdd_homewizard, $connexion);

/*
déclaration des variables locales
*/
$count_passages = 0;
$etat_alarme_bdd = " ";
$alarme_armement = " ";
$timer_now = date('i');
$maintenant = date("Y-m-d H:i:s");
$lancement = date("Y-m-d H:i:s");
$update =  date("Y-m-d H:i:s");
$now = date("Y/m/d H:i:s", strtotime("now"));
$req=mysql_query("SELECT `etat_variable` FROM `variable` where `nom_variable`='duree_totale'");
$res = mysql_fetch_row($req) or die (mysql_error());
$duree_script=$res[0];
$req=mysql_query("SELECT `etat_variable` FROM `variable` where `nom_variable`='duree_pause'");
$res = mysql_fetch_row($req) or die (mysql_error());
$duree_pause=$res[0];
//$later = date("Y/m/d H:i:s", strtotime('+3 minutes',strtotime($now)));
$later = date("Y/m/d H:i:s", strtotime('+'.$duree_script.' minutes',strtotime($now)));
/*
identification du processus :
*/

$pv=shell_exec("ps | grep ".realpath(__FILE__));


$ps = shell_exec('pidof php56 '.basename ($_SERVER['SCRIPT_NAME']));

if ($ps > 0) 
{
	echo "<br>process ID ".basename ($_SERVER['SCRIPT_NAME']);
	echo " <br>ps : ".$ps." "; 
	echo "process complet : ps | grep ".realpath(__FILE__);
	print_r($pv);
	echo "<br>ca tourne <br>";
	/*
	echo "<br><br>test infos<br><br>";
	print_r($ps);
	echo "<br> test array <br>";
	$pieces = multiexplode(array(" ","  ","\t","\n"), $pv);
	print_r($pieces);
	*/

}
else
{
	echo "ca tourne pas <br>";
}




/*
récupérer dans la bdd l'etat de l'armement de l'alarme
*/

$query=("SELECT etat FROM $table_histo where nom='alarme_armement' ORDER BY horodatage DESC  limit 0,1");
$row = mysql_fetch_row(mysql_query($query));
$alarme_armement = $row[0];

/*
récupération des valeurs sur la box domotique
*/
bak:
$json = file_get_contents($jsonurl);
while ($json === false)
{
include ('homewizard/update_procedure/premier_passage_false.inc.php');
}
include ('homewizard/update_procedure/premier_passage_true.inc.php');
echo realpath(__FILE__)." \n";
$maintenant = date("Y-m-d H:i:s");
echo "\n".$maintenant." fin initialisation et debut de la boucle\n";
	while ($later > $now) 
		{
		$now = date("Y/m/d H:i:s", strtotime("now"));
		/*
		900 car 1 seconde de pause à chaque fois
		récupération des valeurs sur la box domotique
		*/
		returnbis:
		$json = file_get_contents($jsonurl);
		if ($json === false)
			{
			sleep($duree_pause);
			$maintenant = date("Y-m-d H:i:s");
			echo $maintenant." recuperation impossible\n";
			$error = error_get_last();
			/*log*/
			$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'recup', '$error[message]')");
			mysql_query($query) or die (mysql_error());
			$query=("UPDATE $table SET etat='KO' WHERE nom LIKE 'etat_box_domotique'");
			mysql_query($query) or die (mysql_error());
			/*/log*/
			goto returnbis;
			} 
		else 
			{
			$data = json_decode($json,true);
			$switches =  $data['response']['switches'];
			$thermo = $data['response']['thermometers'];
			$kaku = $data['response']['kakusensors'];
			include('homewizard/update_procedure/recup_switch.inc.php');
			include('homewizard/update_procedure/recup_kaku.inc.php');
			include('homewizard/update_procedure/recup_thermo.inc.php');
			include('homewizard/update_scenarios/scenarios.inc.php');
			$query=("UPDATE $table SET etat='OK' WHERE nom LIKE 'etat_box_domotique'");
			mysql_query($query) or die (mysql_error());
			sleep($duree_pause);
			}/*if json bis true*/
		}/*fin while*/
	$maintenant = date("Y-m-d H:i:s");
	echo 'lance a '.$lancement.' fin execution '.$maintenant.' '.$count_passages.' passages\n';

	$query=("INSERT IGNORE INTO $table_log (categorie, message) VALUES ( 'script', 'lance a $lancement fin execution $maintenant $count_passages passages')");
	mysql_query($query) or die (mysql_error());
	/*/log*/

mysql_close();
?>