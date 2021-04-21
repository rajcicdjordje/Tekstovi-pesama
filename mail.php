<?php
$email = 'djordje.rajcic.21.14@ict.edu.rs';
$headers = 'From: djordje.rajcic.95@gmail.com'       . "\r\n" .
		   'Reply-To: djordje.rajcic.95@gmail.com' . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();
$mail = mail($email,"Potvrda","Molimo potvrdite ovim linkom http://tekstovi-pesama.eu3.biz/potvrda.php?email=$email .",$headers);
if($email)
 echo "Poslato";
else
 echo "Nije poslato";