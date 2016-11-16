<?php
/* 
include('../variable.inc.php');

test gestion globale variables 
si mise en prod, fichier à prendre en compte et choses à modifier :
- toutes les références à la variables $bdd dans le dossier homewizard et associés avant de supprimer le fichier variable.inc.php qui est dans le dossier homewizard

dossiers vérifiés :
-CV (utilisation en cours)
-freebox (utilisation en cours)
- homewizard/update_fonctions/mail.inc.php
- homewizard/index/portes.php
- homewizard/index/scenes.php
- homewizard/index/scenarios.php
- homewizard/index/inc.add_scenarios.php
- homewizard/index/actions_programmees.php
- homewizard/index/temperature.php
- homewizard/index/freebox.php
- homewizard/index/rapport.php
- homewizard/index/reveil.php
- homewizard/index/modif.php
- homewizard/index/debug.php
- homewizard/admin/index.php
- Homewizard/index/graphique.php
- homewizard/update_fonctions/mail.inc.php
- homewizard/update_fonctions/switch_preset.inc.php
- homewizard/update.php (fait à 13H52)
dossiers à vérifier :
- musique
- SMS
- Synology
- travail
ajout :/volume1/web dans open_basedir (webstation / Paramètres PHP Open base dir) fait le 11/10/2016 à 16H45. ça sert à rien ^^

-->*/
echo "<!-- chargement var base de données -->";
$ip_loc=$_SERVER["SERVER_ADDR"];
$hostname=$ip_loc;
$user="root";
$bdd_homewizard="homewizard";/*change $bdd*/
$passwd_homewizard ="fckgwrhqq2";/*change passwd*/
$table="etat";
$table_histo="historique";
$table_scenario="scenario";
$table_action_prog="action_programmee";
$table_log="log";
$table_usr="utilisateurs";
$table_recup_json="recup_json";
$connexion = mysql_pconnect($hostname, $user, $passwd_homewizard) or die(mysql_error());
mysql_select_db($bdd_homewizard, $connexion);
$req=mysql_query("SELECT `etat_variable` FROM `variable` where `nom_variable`='duree_totale'");
$res = mysql_fetch_row($req) or die (mysql_error());
$duree_script=$res[0];
$req=mysql_query("SELECT `etat_variable` FROM `variable` where `nom_variable`='duree_pause'");
$res = mysql_fetch_row($req) or die (mysql_error());
$duree_pause=$res[0];
echo "<!--chargement var box domotique-->";
$ip_serv="192.168.0.48";
$passwd_box="fckgwrhqq2";
$lien_racine="http://frederic.suretat.com";
$ip_ext=$_SERVER["HTTP_HOST"];
$nom_fichier_update="update_homewizard.php";
$base_url = "http://".$ip_serv."/".$passwd_box;
$get_sens = $base_url."/get-sensors";
$get_location = $base_url."/wea/get";
$get_timers = $base_url."/timers";
$get_te_year = $base_url."/te/graph/0/year";
$get_te_week = $base_url."/te/graph/0/week";
$get_te_month = $base_url."/te/graph/0/month";
$get_te_list = $base_url."/telist";
$get_te_day = $base_url."/te/graph/0/day";
$get_switch_list = $base_url."/swlist";
$get_suntime_today = $base_url."/suntimes/today";
$get_notification_receiver = $base_url."/nf-receivers";
$get_scene_list = $base_url."/gplist";
$get_state_sensors = $base_url."/get-status";
$jsonurl = $get_sens;
$custom_url = $base_url;
$preset_home=$base_url."/preset/0";
$preset_away=$base_url."/preset/1";
$preset_sleep=$base_url."/preset/2";
$preset_holiday=$base_url."/preset/3";
$nom_switch[]=array();
$etat_switch[]=array();
$nom_kaku[]=array();
$etat_kaku[]=array();
$nom_thermo[]=array();
$etat_thermo[]=array();
$etat_bdd_switch[]=array();
$etat_bdd_histo_kaku[]=array();
$etat_bdd_thermo[]=array();
$mail_from="serveur@suretat.com";
$mail_to="fred.suretat@gmail.com";

/*chargement variables scenarios*/
include ('homewizard/update_scenarios/variable_scenarios.inc.php');
//$freeboxapkey='net.aissam.test1';
//$freeboxapkeypwd="zP+0jVer4q65LTZVXdRUTTk6Z2gXyNWnGfKYcWyKA4AAdkYGii12/ejr2klAXtWV";

/*travail include ('../travail/releve_heures/variables.php'); :*/
$bdd_travail = "CV_FRED";
$user_travail  = "root";
$passwd_travail  = "fckgwrhqq2";
$table_travail[1]= "paye";
$table_travail[2]="retenues";
$table_travail[3]="entreprise";
$table_travail[4]="mission";
$table_travail[5]="releve_heures";
$table_civilite= "Civilite";
/*freebox*/
$url_freebox_dist_https="https://suretat.freeboxos.fr:445";
$url_freebox_dist="http://suretat.freeboxos.fr:444";
/*musique*/
$bdd_musique = "musique";
$password_musique = "fckgwrhqq2";
?>