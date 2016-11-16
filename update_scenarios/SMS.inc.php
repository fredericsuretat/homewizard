<?php
$envoi = stream_context_create(array(
    'http' => array(
    'method'  => 'POST',
    'header'  => "Content-type: application/x-www-form-urlencodedrn",
    ),
));

$SMS = file_get_contents('https://smsapi.free-mobile.fr/sendmsg?user='.$phone_user.'&pass='.$phone_pass.'&msg='.$message. '',false,$envoi);
print_r($SMS);

$update =  date("Y-m-d H:i:s");
echo $update."Envoi d'un SMS a :".$phone_nom."\n";

?>