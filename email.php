<?php 
include('konekcija.inc');
if(isset($_REQUEST['email']))
{
		$email = $_REQUEST['email'];
        $upit = "SELECT * FROM korisnici WHERE email='$email'";
		$rez = mysqli_query($konekcija,$upit);
		if(mysqli_num_rows($rez)!=0)
		{
		echo "Ovaj mail je zauzet, molimo izaberite drugi.";
		}
		else
		{
		echo "";
		}
}
include('zatvori.inc');
?>