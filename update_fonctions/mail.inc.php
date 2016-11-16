<?php


function envoi_mail($subject,$message)
{
			$message = wordwrap($message, 70, "\r\n");

					// Envoi du mail
					$headers  = 'MIME-Version: 1.0' . "\r\n";
    				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    				// En-têtes additionnels
					$headers .= 'To: fred <'.$mail_to.'>' . "\r\n";
					$headers .= 'From: serveur <'.$mail_from.'>' . "\r\n";
					$to = $mail_to;
     				// Envoi
     				mail($to, $subject, $message, $headers);
					/*fin du test*/
				
}
?>