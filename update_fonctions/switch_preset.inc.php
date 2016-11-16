<?php
/*
input attendus
$preset_home = "http://".$ip_serv."/".$passwd."/preset/0";
$preset_away = "http://".$ip_serv."/".$passwd."/preset/1";
$preset_sleep = "http://".$ip_serv."/".$passwd."/preset/2";
$preset_holiday = "http://".$ip_serv."/".$passwd."/preset/3";
*/

function switch_preset($preset)
{

  switch ($preset) 
  	{
    case 0:
        $retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd_box.'/preset/0');
        break;
    case 1:
        $retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd_box.'/preset/1');
        break;
    case 2:
        $retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd_box.'/preset/2');
        break;
    case 3:
        $retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd_box.'/preset/3');
        break;
   	case 4:
        $retour = @file_get_contents('http://'.$ip_serv.'/'.$passwd.'/preset/4');
        break;
   		
	}
	
}
?>