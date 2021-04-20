<?php 
include('konekcija.inc');
if(isset($_REQUEST['korIme']))
{
		$korIme = $_REQUEST['korIme'];
        $upit = "SELECT * FROM korisnici WHERE korisnicko_ime='$korIme'";
		$rez = mysqli_query($konekcija,$upit);
		if(mysqli_num_rows($rez)!=0)
		{
		echo "Korisnicko ime je vec zauzeto.";
		}
		else
		{
		echo "";
		}
}
include('zatvori.inc');
?>