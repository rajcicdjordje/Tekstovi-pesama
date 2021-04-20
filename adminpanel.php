<?php 
@session_start();
if(!isset($_SESSION['idU']) || $_SESSION['idU']!=2)
{
	header("Location: index.php");
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title>Admin panel - Tekstovi pesama</title>
<script type="text/javascript">
function funkcija()
{
var select = document.getElementById("admin_izbor").options[document.getElementById("admin_izbor").selectedIndex].value;
forma.action = "adminpanel.php?izbor="+select;
forma.submit();
}
</script>
<style type="text/css">
#tableK
{
font-size:26px;
}
#tableK tr th
{
background:yellow;
}
</style>
<script type="text/javascript" src="jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css.css"/>
<link rel="stylesheet" href="jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="gallery.js"></script>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="forma" style="margin-left:44%;">
<select name="admin_izbor" id="admin_izbor" onChange="funkcija();">
<option value="0">Izaberite tabelu...</option>
<option value="Korisnici">Korisnici</option>
<option value="Galerije">Galerije</option>
<option value="Slike">Slike</option>
<option value="Linkovi">Linkovi</option>
<option value="Tekstovi">Tekstovi</option>
<option value="Zanrovi">Zanrovi</option>
<option value="Uloge">uloge</option>
<option value="Korisnici_uloge">Korisnici_uloge</option>
</select>
</form>
<?php 
if(isset($_REQUEST['izbor']))
{
$i=0;
include("konekcija.inc");
include("funkcije.inc");
include("funkcija_male_slike.inc");
$dir_velike = "slike/";
$dir_male = "slike/male_slike/";
if($_REQUEST['izbor']=='Korisnici')
{
$upit = "SELECT * FROM korisnici";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:100%;font-size:25px;'><tr><th>Id korisnika</th><th>Ime</th><th>Prezime</th><th>Korisnicko ime</th><th>Lozinka</th><th>Email</th><th>Verifikacija</th><th colspan='2'><a href='adminpanel.php?izbor=DodajK'>DODAJ KORISNIKA</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_korisnika']."</td>";
echo "<td>".$r['ime']."</td>";
echo "<td>".$r['prezime']."</td>";
echo "<td>".$r['korisnicko_ime']."</td>";
echo "<td>".$r['lozinka']."</td>";
echo "<td>".$r['email']."</td>";
if(@$r['verifikacija']=='1')
{echo "<td>Aktivan</td>";}
else
{echo "<td>Neaktivan</td>";}
echo "<td><a href='adminpanel.php?izbor=IzmenaK&id_korisnika=".$r['id_korisnika']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeK&id_korisnika=".$r['id_korisnika']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r["id_korisnika"]."</td><td>".$r["ime"]."</td><td>".$r["prezime"]."</td><td>".$r["korisnicko_ime"]."</td><td>".$r["lozinka"]."</td><td>".$r["email"]."</td><td>";if(@$r['verifikacija']=='1'){echo 'Aktivan';}else{echo 'Neaktivan';}; echo"</td><td><a href='adminpanel.php?izbor=IzmenaK&id_korisnika=".$r['id_korisnika']."'>IZMENI</a></td><td><a href='adminpanel.php?izbor=BrisanjeK&id_korisnika=".$r['id_korisnika']."'>OBRISI</a></td></tr>";  
}
$i++;
}
echo "</table><br/><br/>";
}
if($_REQUEST['izbor']=='IzmenaK')
{
if(isset($_REQUEST['btnPromenaK']))

{
					$id_korisnika = $_REQUEST['id_korisnika'];
					$verifikacija = $_REQUEST['verifikacija'];
					$ime = $_REQUEST['ime'];
					$prezime = $_REQUEST['prezime'];
					$korisnicko_ime = $_REQUEST['korisnicko_ime'];
					$email = $_REQUEST['email'];
					$lozinka = $_REQUEST['lozinka'];
					$regIme = "/^[A-Ž]{1}[a-ž]{2,14}$/";
					$regPrezime = "/^[A-Ž]{1}[a-ž]{3,17}$/";
					$regEmail = "/^(\w+[\-\.])*\w+@(\w+\.)+[A-Za-z]+$/";
					$regKorisnickoIme = "/^[A-ž]{3,}([A-ž]|[0-9])*$/";
					$regLozinka = "/^[A-ž]{1}([A-ž]|[0-9]|\!|\?|\_)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regIme, $ime))
					{
						$greske[] = "Ime nije u dobrom formatu.";
					}
					if(!preg_match($regPrezime, $prezime))
					{
						$greske[] = "Prezime nije u dobrom formatu.";
					}
					if(!preg_match($regEmail, $email))
					{
						$greske[] = "Email nije u dobrom formatu.";
					}
					if(!preg_match($regKorisnickoIme, $korisnicko_ime))
					{
						$greske[] = "Korisnicko ime nije u dobrom formatu.";
					}
					if($lozinka != "")
					{
					if(!preg_match($regLozinka, $lozinka))
					{
						$greske[] = "Lozinka nije u dobrom formatu.";
					}
					else
					{
						$lozinka = md5($lozinka);
					}
					}
					if(count($greske)!=0)
					{
						echo "<div id='ispis'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{	
						if($lozinka!="")
						$upit = "UPDATE korisnici SET ime='$ime', prezime='$prezime', korisnicko_ime='$korisnicko_ime', lozinka='$lozinka', email='$email', verifikacija='$verifikacija' WHERE id_korisnika=".$id_korisnika;
						else
						$upit = "UPDATE korisnici SET ime='$ime', prezime='$prezime', korisnicko_ime='$korisnicko_ime', email='$email', verifikacija='$verifikacija' WHERE id_korisnika=".$id_korisnika;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							$subject = 'Potvrda';
							$message = 'Molimo potvrdite ovim linkom https://tekstovi-pesama.eu3.biz/potvrda.php?email=$email .';
							$to = "$email";
							$type = 'plain'; // or HTML
							$charset = 'utf-8';

							$mail     = 'no-reply@'.str_replace('www.', '', $_SERVER['SERVER_NAME']);
							$uniqid   = md5(uniqid(time()));
							$headers  = 'From: '.$mail.PHP_EOL;
							$headers .= 'Reply-to: '.$mail.PHP_EOL;
							$headers .= 'Return-Path: '.$mail.PHP_EOL;
							$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">".PHP_EOL;
							$headers .= 'MIME-Version: 1.0'.PHP_EOL;
							$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time()).PHP_EOL;
							$headers .= 'X-Priority: 3'.PHP_EOL;
							$headers .= 'X-MSMail-Priority: Normal'.PHP_EOL;
							$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'.PHP_EOL;
							$headers .= '------------'.$uniqid.PHP_EOL;
							$headers .= 'Content-type: text/'.$type.';charset='.$charset.''.PHP_EOL;
							$headers .= 'Content-transfer-encoding: 7bit';

							$m = mail($to, $subject, $message, $headers);					
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Korisnici&m=$m\"</script>");							

						}
					}
					}
else
{
	$id = $_REQUEST['id_korisnika'];
	$upit = "SELECT * FROM korisnici WHERE id_korisnika=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if(mysqli_num_rows($rez)>0)
	{
		$r = mysqli_fetch_array($rez);
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Ime:</td><td><input type='text' name='ime' value='".$r['ime']."'/></td></tr>";
		echo "<tr><td>Prezime</td><td><input type='text' name='prezime' value='".$r['prezime']."'/></td></tr>";
		echo "<tr><td>Korisnicko ime</td><td><input type='text' name='korisnicko_ime' value='".$r['korisnicko_ime']."'/></td></tr>";
		echo "<tr><td>Lozinka</td><td><input type='text' name='lozinka' placeholder='Promena lozinke'/></td></tr>";
		echo "<tr><td>Email</td><td><input type='text' name='email' value='".$r['email']."'/></td></tr>";
		echo "<input type='hidden' name='izbor' value='IzmenaK'/>";
		echo "<input type='hidden' name='id_korisnika' value='".$r['id_korisnika']."'/>";
		if($r['verifikacija']=='0')
		{echo "<tr><td>Verifikacija</td><td><select name='verifikacija' id='verifikacija'><option value='1'>Aktivan</option><option value='0' selected>Neaktivan</option></select></td></tr>";}
		else
		{echo "<tr><td>Verifikacija</td><td><select name='verifikacija' id='verifikacija'><option value='1' selected>Aktivan</option><option value='0'>Neaktivan</option></select></td></tr>";}
		echo "<tr><td><input type='submit' name='btnPromenaK' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Korisnici'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	}
	
}
}
if($_REQUEST['izbor']=='BrisanjeK')
{
	$id = $_REQUEST['id_korisnika'];
	$upit = "DELETE FROM korisnici WHERE id_korisnika=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Korisnici\"</script>");
	}
}
if($_REQUEST['izbor']=='DodajK')
{
if(isset($_REQUEST['btnDodajK']))
{
					
					$verifikacija = $_REQUEST['verifikacija'];
					$ime = $_REQUEST['ime'];
					$prezime = $_REQUEST['prezime'];
					$korisnicko_ime = $_REQUEST['korisnicko_ime'];
					$email = $_REQUEST['email'];
					$lozinka = $_REQUEST['lozinka'];
					$regIme = "/^[A-Ž]{1}[a-ž]{2,14}$/";
					$regPrezime = "/^[A-Ž{1}[a-ž]{3,17}$/";
					$regEmail = "/^(\w+[\-\.])*\w+@(\w+\.)+[A-Za-z]+$/";
					$regKorisnickoIme = "/^[A-ž]{3,}([A-ž]|[0-9])*$/";
					$regLozinka = "/^[A-ž]{1}([A-ž]|[0-9]|\!|\?|\_)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regIme, $ime))
					{
						$greske[] = "Ime nije u dobrom formatu.";
					}
					if(!preg_match($regPrezime, $prezime))
					{
						$greske[] = "Prezime nije u dobrom formatu.";
					}
					if(!preg_match($regEmail, $email))
					{
						$greske[] = "Email nije u dobrom formatu.";
					}
					if(!preg_match($regKorisnickoIme, $korisnicko_ime))
					{
						$greske[] = "Korisnicko ime nije u dobrom formatu.";
					}					
					if(!preg_match($regLozinka, $lozinka))
					{
						$greske[] = "Lozinka nije u dobrom formatu.";
					}
					else
					{
						$lozinka = md5($lozinka);
					}					
					if(count($greske)!=0)
					{
						echo "<div id='ispis'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "INSERT INTO korisnici VALUES('','$ime','$prezime','$korisnicko_ime','$lozinka','$email','$verifikacija')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							if($verifikacija=='0')
							$mail = mail("$email","Potvrda","Molimo potvrdite ovim linkom https://tekstovi-pesama.eu3.biz/potvrda.php?email=$email .");
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Korisnici\"</script>");						
						}
					}
}
else
{
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Ime:</td><td><input type='text' name='ime' /></td></tr>";
		echo "<tr><td>Prezime</td><td><input type='text' name='prezime' /></td></tr>";
		echo "<tr><td>Korisnicko ime</td><td><input type='text' name='korisnicko_ime' /></td></tr>";
		echo "<tr><td>Lozinka</td><td><input type='text' name='lozinka' /></td></tr>";
		echo "<tr><td>Email</td><td><input type='text' name='email' /></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajK'/>";
		echo "<tr><td>Verifikacija</td><td><select name='verifikacija' id='verifikacija'><option value='1'>Aktivan</option><option value='0' selected>Neaktivan</option></select></td></tr>";
		echo "<tr><td><input type='submit' name='btnDodajK' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Korisnici'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='Galerije')
{
$upit = "SELECT * FROM galerije";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:50%;margin:0 auto;font-size:26px'><tr><th>Id galerije</th><th>Naziv galerije</th><th colspan='2'><a href='adminpanel.php?izbor=DodajG'>DODAJ GALERIJU</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_galerije']."</td>";
echo "<td>".$r['naziv_galerije']."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaG&id_galerije=".$r['id_galerije']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeG&id_galerije=".$r['id_galerije']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r["id_galerije"]."</td>";
echo "<td>".$r["naziv_galerije"]."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaG&id_galerije=".$r['id_galerije']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeG&id_galerije=".$r['id_galerije']."'>OBRISI</a></td></tr>";  
}
$i++;
}
echo "</table>";
}
if($_REQUEST['izbor']=='DodajG')
{
if(isset($_REQUEST['btnDodajG']))
{
					
					$naziv_galerije = $_REQUEST['naziv_galerije'];
					$regNaziv_galerije = "/^[A-z]{3,}([A-z]|[0-9])*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_galerije, $naziv_galerije))
					{
						$greske[] = "Naziv galerije nije u dobrom formatu.";
					}				
					if(count($greske)!=0)
					{
						echo "<div id='ispis'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "INSERT INTO galerije VALUES('','$naziv_galerije')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Galerije\"</script>");
						}
					}
}
else
{
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv galerije</td><td><input type='text' name='naziv_galerije' /></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajG'/>";
		echo "<tr><td><input type='submit' name='btnDodajG' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Galerije'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaG')
{
if(isset($_REQUEST['btnPromenaG']))
{
					$naziv_galerije = $_REQUEST['naziv_galerije'];
					$id_galerije = $_REQUEST['id_galerije'];
					$regNaziv_galerije = "/^[A-z]{3,}([A-z]|[0-9]|\s)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_galerije, $naziv_galerije))
					{
						$greske[] = "Naziv galerije nije u dobrom formatu.";
					}				
					if(count($greske)!=0)
					{
						echo "<div id='ispis'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "UPDATE galerije SET naziv_galerije='$naziv_galerije' WHERE id_galerije=".$id_galerije;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Galerije\"</script>");		
		}
					}		
}
else
{
		$id_galerije = $_REQUEST['id_galerije'];
		$upit = "SELECT * FROM galerije WHERE id_galerije=".$id_galerije;
		$rez = mysqli_query($konekcija,$upit);
		$r = mysqli_fetch_array($rez);
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv galerije</td><td><input type='text' name='naziv_galerije' value='".$r['naziv_galerije']."'/></td></tr>";
		echo "<input type='hidden' name='izbor' value='IzmenaG'/>";
		echo "<input type='hidden' name='id_galerije' value='".$id_galerije."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaG' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Galerije'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeG')
{
	$id = $_REQUEST['id_galerije'];
	$upit = "DELETE FROM galerije WHERE id_galerije=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Galerije\"</script>");
	}
}
if($_REQUEST['izbor']=='Slike')
{
$upit = "SELECT * FROM slike";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:100%;margin:0 auto;font-size:26px'><tr><th>Id slike</th><th>Id galerije</th><th>Naziv slike</th><th>Slika</th><th>Izgled slike</th><th colspan='2'><a href='adminpanel.php?izbor=DodajS'>DODAJ SLIKU</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_slike']."</td>";
echo "<td>".$r['id_galerije']."</td>";
echo "<td>".$r['naziv_slike']."</td>";
echo "<td>".$r['slika']."</td>";
echo "<td><a class='fancybox' rel='group' href='".$dir_velike.$r['slika']."' title='".$r['naziv_slike']."'>";
echo "<img src='".$dir_male.$r['slika']."' alt='".$r['naziv_slike']."'/></a></td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaS&id_slike=".$r['id_slike']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeS&id_slike=".$r['id_slike']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r['id_slike']."</td>";
echo "<td>".$r['id_galerije']."</td>";
echo "<td>".$r['naziv_slike']."</td>";
echo "<td>".$r['slika']."</td>";
echo "<td><a class='fancybox' rel='group' href='".$dir_velike.$r['slika']."' title='".$r['naziv_slike']."'>";
echo "<img src='".$dir_male.$r['slika']."' alt='".$r['naziv_slike']."'/></a></td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaS&id_slike=".$r['id_slike']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeS&id_slike=".$r['id_slike']."'>OBRISI</a></td></tr>";
}
$i++;
}
echo "</table><br/><br/>";
}
if($_REQUEST['izbor']=='DodajS')
{
if(isset($_REQUEST['btnDodajS']))
{
		$ime_slike = $_REQUEST['tbImeSlike'];
		$idGalerije = $_REQUEST['ddlGalerija'];
		
		$ime_fajla = $_FILES['tbSlika']['name'];
		$tmp_fajla = $_FILES['tbSlika']['tmp_name'];
		$tip_fajla = $_FILES['tbSlika']['type'];
		
		$dir_velike = "slike/";
		$dir_male = "slike/male_slike/";
		
		$galerija = "galerija_".$idGalerije;
		$putanja_slike = $galerija.$ime_fajla;
		
		
		if($tip_fajla == "image/jpg" || $tip_fajla == "image/jpeg" || $tip_fajla == "image/png")
		{
			if(move_uploaded_file($tmp_fajla, $dir_velike.$putanja_slike))
			{
				malaslika($dir_velike.$putanja_slike, $dir_male.$putanja_slike, 200, 200);
								
								
				$upit_upis = "INSERT INTO slike VALUES('', $idGalerije, '$ime_slike', '$putanja_slike')";
				
				$rez_upis = mysqli_query($konekcija,$upit_upis);
				
				if(!$rez_upis)
				{
					$greske[] = "Greska prilikom upisa".mysqli_error($konekcija);
				}
				
			}
		}
		else
		{
			$greske[] = "Nije dozvoljen nijedan tip fajla sem jpg/jpeg ili png!";
		}
		if(count($greske)!=0)
		{
			echo "<div id='ispis'><ul>";
			foreach($greske as $g)
			{
			echo "<li>$g</li>";
			}
			echo "</ul></div>";
		}
		else
		{
			print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Slike\"</script>");
		}
		
}
else
{
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" name="form" enctype="multipart/form-data">
	     <table style="width:500px; margin:0 auto;">
		     <tr>
			     <th colspan="2">Postavljanje i obrada slika</th>
			 </tr>
			 <tr>
			    <td>Naziv slike:</td>
				<td>
				   <input type="text" class="styled" id="tbImeSlike" name="tbImeSlike" />
				</td>
			 </tr>
			 <tr>
			    <td>Slika:</td>
				<td>
				   <input type="file" class="styled" id="tbSlika" name="tbSlika" />
				   <input type="hidden" class="styled" id="izbor" name="izbor" value="DodajS"/>
				</td>
			 </tr>
                         <tr>
			    <td>Galerija:</td>
				<td>
                    <select name="ddlGalerija" id="ddlGalerija">
                        <option value='0'>Izaberite galeriju....</option>
<?php
	$upit_g = "SELECT * FROM galerije ORDER BY naziv_galerije";
	$rez_g = mysqli_query($konekcija,$upit_g) or die("Greska prilikom iscitavanja galerija!");
	
	while($r=mysqli_fetch_array($rez_g))
	{
		echo "<option value='{$r['id_galerije']}'>{$r['naziv_galerije']}</option>";
	}
	
?>
                    </select>
				</td>
			 </tr>
			 <tr>
			    <td align="center">
				    <input type="submit" value="Dodaj sliku" class="button" name="btnDodajS" />
				</td>
				<td align="center"><a href='adminpanel.php?izbor=Slike'><input type='button' value='Odustani'/></a></td>
			 </tr>
		 </table>
	  
	  </form>
<?php		
}
}
if($_REQUEST['izbor']=='IzmenaS')
{
if(isset($_REQUEST['btnPromenaS']))
{
		
		$ime_slike = $_REQUEST['tbImeSlike'];
		$idGalerije = $_REQUEST['ddlGalerija'];
		$id_slike = $_REQUEST['id_slike'];
		$ime_fajla = $_FILES['tbSlika']['name'];
		$tmp_fajla = $_FILES['tbSlika']['tmp_name'];
		$tip_fajla = $_FILES['tbSlika']['type'];
		
		$dir_velike = "slike/";
		$dir_male = "slike/male_slike/";
		
		$galerija = "galerija_".$idGalerije;
		$putanja_slike = $galerija.$ime_fajla;
		
		if($ime_fajla!="")
		{
		$upit = "SELECT slika FROM slike WHERE id_slike=".$id_slike;
		$rez = mysqli_query($konekcija,$upit);
		$r = mysqli_fetch_array($rez);
		$h = unlink($dir_male.$r['slika']);
		$h1 = unlink($dir_velike.$r['slika']);
	 /* $g = delete($dir_velike.$r['slika']);
	    $g1 = delete($dir_male.$r['slika']); */
		if($tip_fajla == "image/jpg" || $tip_fajla == "image/jpeg" || $tip_fajla == "image/png")
		{
			if(move_uploaded_file($tmp_fajla, $dir_velike.$putanja_slike))
			{
				malaslika($dir_velike.$putanja_slike, $dir_male.$putanja_slike, 200, 200);
								
								
				$upit_upis = "UPDATE slike 
							  SET id_galerije=$idGalerije, naziv_slike='{$ime_slike}', slika='{$putanja_slike}'
							  WHERE id_slike=".$id_slike;
				
				$rez_upis = mysqli_query($konekcija,$upit_upis);
				
				if(!$rez_upis)
				{
					$greske[] = "Greska prilikom upisa".mysqli_error($konekcija);
				}
				
			}
		}
		else
		{
			$greske[] = "Nije dozvoljen nijedan tip fajla sem jpg/jpeg ili png!";
		}
		}
		else
		{
				$upit_upis = "UPDATE slike 
							  SET id_galerije=$idGalerije, naziv_slike='{$ime_slike}'
							  WHERE id_slike=".$id_slike;
				
				$rez_upis = mysqli_query($konekcija,$upit_upis);
				
				if(!$rez_upis)
				{
					$greske[] = "Greska prilikom upisa".mysqli_error($konekcija);
				}
				
			
		}
		if(count($greske)!=0)
		{
			echo "<div id='ispis'><ul>";
			foreach($greske as $g)
			{
			echo "<li>$g</li>";
			}
			echo "</ul></div>";
		}
		else
		{
			print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Slike\"</script>");
		}
		
}
else
{
$id_slike = $_REQUEST['id_slike'];
$upit = "SELECT * FROM slike WHERE id_slike=".$id_slike;
$rez = mysqli_query($konekcija,$upit);
$r = mysqli_fetch_array($rez);
$id_galerije = $r['id_galerije'];
$naziv_slike = $r['naziv_slike'];
$slika = $r['slika'];
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" name="form" enctype="multipart/form-data">
	     <table style="width:500px; margin:0 auto;">
		     <tr>
			     <th colspan="2">Promena i obrada slika</th>
			 </tr>
			 <tr>
			    <td>Naziv slike:</td>
				<td>
				   <input type="text" class="styled" id="tbImeSlike" name="tbImeSlike" value="<?php echo $naziv_slike;?>"/>
				</td>
			 </tr>
			 <tr>
			    <td>Slika:</td>
				<td>
				   <input type="file" class="styled" id="tbSlika" name="tbSlika" value="<?php echo $slika;?>"/>
				   <input type="hidden" class="styled" id="izbor" name="izbor" value="IzmenaS"/>
				   <input type="hidden" class="styled" id="id_slike" name="id_slike" value="<?php echo $id_slike;?>"/>
				</td>
			 </tr>
                         <tr>
			    <td>Galerija:</td>
				<td>
                    <select name="ddlGalerija" id="ddlGalerija">
                        <option value='0'>Izaberite galeriju....</option>
<?php
	$upit_g = "SELECT * FROM galerije ORDER BY naziv_galerije";
	$rez_g = mysqli_query($konekcija,$upit_g) or die("Greska prilikom iscitavanja galerija!");
	
	while($r=mysqli_fetch_array($rez_g))
	{
		if($r['id_galerije']==$id_galerije)
		echo "<option value='{$r['id_galerije']}' selected>{$r['naziv_galerije']}</option>";
		else
		echo "<option value='{$r['id_galerije']}'>{$r['naziv_galerije']}</option>";
	}
	
?>
                    </select>
				</td>
			 </tr>
			<tr><td colspan='2' align='center'><a class='fancybox' rel='group' href="<?php echo $dir_velike.$slika;?>" title="<?php echo $naziv_slike;?>">;
			<img src="<?php echo $dir_male.$slika;?>" alt="<?php echo $naziv_slike;?>"/></a></td>;
			 <tr>
			    <td align="center">
				    <input type="submit" value="Izmeni sliku" class="button" name="btnPromenaS" />
				</td>
				<td align="center"><a href='adminpanel.php?izbor=Slike'><input type='button' value='Odustani'/></a></td>
			 </tr>
		 </table>
	  
	  </form>
<?php		

}
}
if($_REQUEST['izbor']=='BrisanjeS')
{
	$dir_velike = "slike/";
	$dir_male = "slike/male_slike/";
	$id = $_REQUEST['id_slike'];
	$upit_slika = "SELECT slika FROM slike WHERE id_slike=".$id;
	$rez_slika = mysqli_query($konekcija,$upit_slika);
	if($rez_slika)
	{
	 $r1 = mysqli_fetch_array($rez_slika);
	 $h = unlink($dir_male.$r1['slika']);
	 $h1 = unlink($dir_velike.$r1['slika']);
  /* $g = delete($dir_velike.$r1['slika']);
	 $g1 = delete($dir_male.$r1['slika']); */
	}
	$upit = "DELETE FROM slike WHERE id_slike=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Slike\"</script>");
	}
	
}
include("linkovi.php");
include("zanrovi.php");
include("tekstovi1.php");
include("uloge.php");
include("korisnici_uloge.php");
}
?>
</body>
</html>
<?php
}
?>