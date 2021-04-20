<?php 
@session_start();
include('konekcija.inc');
if(isset($_REQUEST['email']))
{
$email = $_REQUEST['email'];
$upit = "UPDATE korisnici SET verifikacija=1 WHERE email='".$email."'";
$rez = mysqli_query($konekcija,$upit);
if($rez)
{
$upit1 = "SELECT * FROM korisnici k JOIN korisnici_uloge ku ON k.id_korisnika=ku.id_korisnika JOIN uloge u ON ku.id_uloge=u.id_uloge WHERE email='$email'";
$rez1 = mysqli_query($konekcija,$upit1);
if($rez1)
{
				$r = mysqli_fetch_array($rez1);
				
				$ime_prezime = $r['ime_prezime'];
				
				$id_uloge = $r['id_uloge'];
				
				$naziv_uloge = $r['naziv_uloge'];
				
				$korisnickoIme = $r['korisnicko_ime'];
				
				$_SESSION['idU'] = $id_uloge;
							
				$_SESSION['kor_ime'] = $korisnickoIme;
							
				setcookie($korisnickoIme, $ime_prezime, time() + (86400*30), "/");
							
				switch($naziv_uloge)
				{
					case 'admin':
					header('Location:index.php');
					break;
					case 'korisnik':
					header('Location:index.php');
					break;
				}
}
}
}
?>