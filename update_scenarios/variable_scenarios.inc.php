<?php
$freeboxapkey='freeboxapkey';
$freeboxapkeypwd="freeboxpassword";

$alarme_use="off";
$telecommande_na="Telecommande Na";
$telecommande_fr=" Telecommandefr";

$temperature_chambre_max=floatval(21);
$temperature_chambre_min=floatval(19);

$porte_chambre="Porte chambre";
$chauffage_chambre_NF="Chauffage chNF";

$porte_chambre_Nila="porteChambrefon" ;
$chaffage_chambre_Nila="Chauf ch fond" ;

$porte_entree="porte_entree";
$lumiere_canap="Lumiere canape";
$phone_user_fred="phone_user";
$phone_pass_fred="phone_pwd";
$phone_user_nadege="phone_user2";
$phone_pass_nadege="phone_pwd2";
$user_SMS[0]['nom']="fred";
$user_SMS[0]['user']="phone_user";
$user_SMS[0]['pass']="phone_pwd";
$user_SMS[1]['nom']="phone_name2";
$user_SMS[1]['user']="phone_user2";
$user_SMS[1]['pass']="phone_pwd";
$phone_user=$phone_user_fred;
$phone_pass=$phone_pass_fred;
$message="Hello%20World%20!";
$sms_url="https://smsapi.free-mobile.fr/sendmsg?user=".$phone_user."&pass=".$phone_pass."&msg=".$message;
?>
