<?php 
if($_REQUEST['izbor']=='Korisnici_uloge')
{
$upit = "SELECT * FROM korisnici_uloge";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:50%;margin:0 auto;font-size:26px'><tr><th>Id korisnici_uloge</th><th>Id uloge</th><th>Id korisnika</th><th colspan='2'><a href='adminpanel.php?izbor=DodajKU'>DODAJ ULOGU KORISNIKU</a></th></tr>";
$i = 0;
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_korisnici_uloge']."</td>";
echo "<td>".$r['id_uloge']."</td>";
echo "<td>".$r['id_korisnika']."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaKU&id_korisnici_uloge=".$r['id_korisnici_uloge']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeKU&id_korisnici_uloge=".$r['id_korisnici_uloge']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r['id_korisnici_uloge']."</td>";
echo "<td>".$r['id_uloge']."</td>";
echo "<td>".$r['id_korisnika']."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaKU&id_korisnici_uloge=".$r['id_korisnici_uloge']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeKU&id_korisnici_uloge=".$r['id_korisnici_uloge']."'>OBRISI</a></td></tr>";  
}
$i++;
}
echo "</table>";
}
if($_REQUEST['izbor']=='DodajKU')
{
if(isset($_REQUEST['btnDodajKU']))
{
					
					$id_korisnika = $_REQUEST['id_korisnika'];
					$id_uloge = $_REQUEST['id_uloge'];
					
					$greske = array();
					if($id_korisnika == 0)
					{
						$greske[] = "Morate izabrati korisnika.";
					}
					if($id_uloge == 0)
					{
						$greske[] = "Morate izabrati ulogu.";
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
						$upit = "INSERT INTO korisnici_uloge VALUES('', '$id_uloge','$id_korisnika')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.hrefadminpanel.php?izbor=Korisnici_ulogescript>");
						}
					}
}
else
{
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Korisnik</td><td><select name='id_korisnika'><option value='0'>Izaberite korisnika</option>";
		$upit = "SELECT * FROM korisnici";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
		echo "<option value='".$r['id_korisnika']."'>".$r['korisnicko_ime']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Uloga</td><td><select name='id_uloge'><option value='0'>Izaberite ulogu</option>";
		$upit = "SELECT * FROM uloge";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
		echo "<option value='".$r['id_uloge']."'>".$r['naziv_uloge']."</option>";
		}
		echo "</select></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajKU'/>";
		echo "<tr><td><input type='submit' name='btnDodajKU' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Korisnici_uloge'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaKU')
{
if(isset($_REQUEST['btnPromenaKU']))
{
					$id_korisnika = $_REQUEST['id_korisnika'];
					$id_uloge = $_REQUEST['id_uloge'];
					$id_korisnici_uloge = $_REQUEST['id_korisnici_uloge'];
					$greske = array();
					if($id_korisnika == 0)
					{
						$greske[] = "Morate izabrati korisnika.";
					}
					if($id_uloge == 0)
					{
						$greske[] = "Morate izabrati ulogu.";
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
						$upit = "UPDATE korisnici_uloge SET id_korisnika='$id_korisnika', id_uloge='$id_uloge' WHERE id_korisnici_uloge=".$id_korisnici_uloge;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Korisnici_uloge\"</script>");
						}
					}		
}
else
{
		$id_korisnici_uloge = $_REQUEST['id_korisnici_uloge'];
		$upit1 = "SELECT * FROM korisnici_uloge WHERE id_korisnici_uloge=".$id_korisnici_uloge;
		$rez1 = mysqli_query($konekcija,$upit1);
		$r1 = mysqli_fetch_array($rez1);
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Korisnik</td><td><select name='id_korisnika'><option value='0'>Izaberite korisnika</option>";
		$upit = "SELECT * FROM korisnici";
		$rez = mysqli_query($konekcija,$upit);
		while($r=mysqli_fetch_array($rez))
		{
		if($r['id_korisnika']==$r1['id_korisnika'])
		echo "<option value='".$r['id_korisnika']."' selected>".$r['korisnicko_ime']."</option>";
		else
		echo "<option value='".$r['id_korisnika']."'>".$r['korisnicko_ime']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Uloga</td><td><select name='id_uloge'><option value='0'>Izaberite ulogu</option>";
		$upit2 = "SELECT * FROM uloge";
		$rez2 = mysqli_query($konekcija,$upit2);
		while($r2=mysqli_fetch_array($rez2))
		{
		if($r2['id_uloge']==$r1['id_uloge'])
		echo "<option value='".$r2['id_uloge']."' selected>".$r2['naziv_uloge']."</option>";
		else
		echo "<option value='".$r2['id_uloge']."'>".$r2['naziv_uloge']."</option>";
		}
		echo "</select></td></tr>";
		echo "<input type='hidden' name='izbor' value='IzmenaKU'/>";
		echo "<input type='hidden' name='id_korisnici_uloge' value='".$id_korisnici_uloge."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaKU' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Korisnici_uloge'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeKU')
{
	$id = $_REQUEST['id_korisnici_uloge'];
	$upit = "DELETE FROM korisnici_uloge WHERE id_korisnici_uloge=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Korisnici_uloge\"</script>");
	}
}
?>