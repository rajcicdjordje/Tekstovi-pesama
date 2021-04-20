<?php 
if($_REQUEST['izbor']=='Tekstovi')
{
$upit = "SELECT * FROM tekstovi";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:100%;margin:0 auto;font-size:26px'><tr><th>Id teksta</th><th>Izvodjac</th><th>Naziv pesme</th><th>Id zanra</th><th>Korisnicko ime</th><th>Verifikacija</th><th colspan='2'><a href='adminpanel.php?izbor=DodajT'>DODAJ TEKST</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_teksta']."</td>";
echo "<td>".$r['izvodjac']."</td>";
echo "<td>".$r['naziv_pesme']."</td>";
$upit1 = "SELECT * FROM zanrovi WHERE id_zanra=".$r['id_zanra'];
$rez1 = mysqli_query($konekcija,$upit1);
$r1 = mysqli_fetch_array($rez1);
echo "<td>".$r1['naziv_zanra']."</td>";
echo "<td>".$r['korisnicko_ime']."</td>";
if($r['verifikacija']==0)
echo "<td>Neaktivan</td>";
else
echo "<td>Aktivan</td>";

echo "<td><a href='adminpanel.php?izbor=IzmenaT&id_teksta=".$r['id_teksta']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeT&id_teksta=".$r['id_teksta']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r['id_teksta']."</td>";
echo "<td>".$r['izvodjac']."</td>";
echo "<td>".$r['naziv_pesme']."</td>";
$upit1 = "SELECT * FROM zanrovi WHERE id_zanra=".$r['id_zanra'];
$rez1 = mysqli_query($konekcija,$upit1);
$r1 = mysqli_fetch_array($rez1);
echo "<td>".$r1['naziv_zanra']."</td>";
echo "<td>".$r['korisnicko_ime']."</td>";
if($r['verifikacija']==0)
echo "<td>Neaktivan</td>";
else
echo "<td>Aktivan</td>";

echo "<td><a href='adminpanel.php?izbor=IzmenaT&id_teksta=".$r['id_teksta']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeT&id_teksta=".$r['id_teksta']."'>OBRISI</a></td></tr>";
}
$i++;
}
echo "</table><br/><br/>";
}
if($_REQUEST['izbor']=='DodajT')
{
if(isset($_REQUEST['btnDodajT']))
{
					$izvodjac = $_REQUEST['izvodjac'];
					$tekst2 = nl2br($_REQUEST['tekst_pesme']);
					$tekst_pesme = mysqli_real_escape_string($konekcija,$tekst2);
					$naziv_pesme = $_REQUEST['naziv_pesme'];
					$link = $_REQUEST['link'];
					$id_zanra = $_REQUEST['id_zanra'];
					$korisnicko_ime = $_REQUEST['korisnicko_ime'];
					$verifikacija = $_REQUEST['verifikacija'];
					$regIzvodjac = "/^([A-ž]|[0-9]|\s)*$/";
					$regNaziv_pesme = "/^([A-ž]|[0-9]|\.|\,|\!|\?|\s)*$/";
					$greske = array();
					if(!preg_match($regNaziv_pesme, $naziv_pesme))
					{
						$greske[] = "Naziv pesme nije u dobrom formatu.";
					}
					if(!preg_match($regIzvodjac, $izvodjac))
					{
						$greske[] = "Naziv izvodjaca nije u dobrom formatu.";
					}
					if($_REQUEST['link']!="")
					{
						$link =  mysqli_real_escape_string($konekcija, urlencode($_REQUEST['link']));
					}
					else
					{
						$link = 'NULL';
					}
					if($id_zanra=="0")
					{
						$greske[] = "Morate izabrati zanr.";
					}					
					if(count($greske)!=0)
					{
						echo "<div id='ispis' style='display:block;'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "INSERT INTO tekstovi VALUES('','$izvodjac','$naziv_pesme','$tekst_pesme','$link','$id_zanra','$korisnicko_ime','$verifikacija')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Tekstovi\"</script>");
						}
					}
}
else
{
		echo "<form name='formK' method='post' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Izvodjac</td><td><input type='text' name='izvodjac' /></td></tr>";
		echo "<tr><td>Naziv pesme</td><td><input type='text' name='naziv_pesme' /></td></tr>";
		echo "<tr><td>Tekst pesme</td><td><textarea rows='26' cols='29' name='tekst_pesme'></textarea></td></tr>";
		echo "<tr><td>Link</td><td><input type='text' name='link' size='32px'/></td></tr>";
		echo "<tr><td>Zanr</td><td><select name='id_zanra' ><option value='0'>Izaberite zanr</option>";
		$upit = "SELECT * FROM zanrovi";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
			echo "<option value='".$r['id_zanra']."'>".$r['naziv_zanra']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Korisnicko ime</td><td><select name='korisnicko_ime'>";
		$upit = "SELECT * FROM korisnici";
		$rez = mysqli_query($konekcija,$upit);
		$korisnik = $_SESSION['kor_ime'];
		$upit1 = "SELECT * FROM korisnici WHERE korisnicko_ime=".$korisnik;
		$rez1 = mysqli_query($konekcija,$upit1);
		$r1 = mysqli_fetch_array($rez1);
		while($r=mysqli_fetch_array($rez))
		{
		if($r['id_korisnika']==$r1['id_korisnika'])
		echo "<option value='".$r['korisnicko_ime']."' selected>".$r['korisnicko_ime']."</option>";
		else
		echo "<option value='".$r['korisnicko_ime']."'>".$r['korisnicko_ime']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Verifikacija</td><td><select name='verifikacija'><option value='0'>Neaktivan</option>";
		echo "<option value='1'>Aktivan</option></select></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajT'/>";
		echo "<tr><td><input type='submit' name='btnDodajT' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Tekstovi'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaT')
{
if(isset($_REQUEST['btnPromenaT']))
{
					$id_teksta = $_REQUEST['id_teksta'];
					$izvodjac = $_REQUEST['izvodjac'];
					$tekst2 = nl2br($_REQUEST['tekst_pesme']);
					$tekst_pesme = mysqli_real_escape_string($konekcija,$tekst2);
					$naziv_pesme = $_REQUEST['naziv_pesme'];
					$link = $_REQUEST['link'];
					$id_zanra = $_REQUEST['id_zanra'];
					$korisnicko_ime = $_REQUEST['korisnicko_ime'];
					$verifikacija = $_REQUEST['verifikacija'];
					$regIzvodjac = "/^([A-ž]|[0-9]|\s)*$/";
					$regNaziv_pesme = "/^([A-ž]|[0-9]|\.|\,|\!|\?|\s)*$/";
					$greske = array();
					if(!preg_match($regNaziv_pesme, $naziv_pesme))
					{
						$greske[] = "Naziv pesme nije u dobrom formatu.";
					}
					if(!preg_match($regIzvodjac, $izvodjac))
					{
						$greske[] = "Naziv izvodjaca nije u dobrom formatu.";
					}
					if($_REQUEST['link']!="")
					{
						$link =  mysqli_real_escape_string($konekcija, urlencode($_REQUEST['link']));
					}
					else
					{
						$link = 'NULL';
					}
					if($id_zanra=="0")
					{
						$greske[] = "Morate izabrati zanr.";
					}					
					if(count($greske)!=0)
					{
						echo "<div id='ispis' style='display:block;'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "UPDATE tekstovi SET izvodjac='$izvodjac', naziv_pesme='$naziv_pesme', tekst_pesme='$tekst_pesme', link='$link', id_zanra='$id_zanra', korisnicko_ime='$korisnicko_ime', verifikacija='$verifikacija' WHERE id_teksta=".$id_teksta;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Tekstovi\"</script>");
						}
					}		
}
else
{
		$id_teksta = $_REQUEST['id_teksta'];
		$upit1 = "SELECT * FROM tekstovi WHERE id_teksta=".$id_teksta;
		$rez1 = mysqli_query($konekcija,$upit1);
		$r1 = mysqli_fetch_array($rez1);
		echo "<form name='formK' method='post' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Izvodjac</td><td><input type='text' name='izvodjac' value='".$r1['izvodjac']."'/></td>";
		echo "<tr><td>Naziv pesme</td><td><input type='text' name='naziv_pesme' value='".$r1['naziv_pesme']."'/></td>";
		echo "<tr><td>Tekst pesme</td><td><textarea rows='26' cols='29' name='tekst_pesme'>".br2nl($r1['tekst_pesme'])."</textarea></td></tr>";
		if($r1['link']==null)
		echo "<tr><td>Link</td><td><input type='text' name='link' size='32px' value=''/></td></tr>";
		else
		echo "<tr><td>Link</td><td><input type='text' name='link' size='32px' value='".urldecode($r1['link'])."'/></td></tr>";
		echo "<tr><td>Zanr</td><td><select name='id_zanra' ><option value='0'>Izaberite zanr</option>";
		$upit = "SELECT * FROM zanrovi";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
			if($r['id_zanra']==$r1['id_zanra'])
			echo "<option value='".$r['id_zanra']."' selected>".$r['naziv_zanra']."</option>";
			else
			echo "<option value='".$r['id_zanra']."'>".$r['naziv_zanra']."</option>";
		}
		echo "</select></td></tr>";		
		echo "<tr><td>Korisnicko ime</td><td><select name='korisnicko_ime'>";
		$upit = "SELECT * FROM korisnici";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
		if($r['korisnicko_ime']==$r1['korisnicko_ime'])
		echo "<option value='".$r['korisnicko_ime']."' selected>".$r['korisnicko_ime']."</option>";
		else
		echo "<option value='".$r['korisnicko_ime']."'>".$r['korisnicko_ime']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Verifikacija</td><td><select name='verifikacija'>:";
		if($r1['verifikacija']==0)
		echo "<option value='0' selected>Neaktivan</option><option value='1'>Aktivan</option></select></td></tr>";
		else
		echo "<option value='0'>Neaktivan</option><option value='1' selected>Aktivan</option></select></td></tr>";		
		echo "<input type='hidden' name='izbor' value='IzmenaT'/>";
		echo "<input type='hidden' name='id_teksta' value='".$id_teksta."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaT' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Tekstovi'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeT')
{
	$id = $_REQUEST['id_teksta'];
	$upit = "DELETE FROM tekstovi WHERE id_teksta=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Tekstovi\"</script>");
	}
}
?>