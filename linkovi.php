<?php
if($_REQUEST['izbor']=='Linkovi')
{
$upit = "SELECT * FROM linkovi";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:50%;margin:0 auto;font-size:26px'><tr><th>Id linka</th><th>Naziv linka</th><th>Putanja</th><th>Roditelj</th><th colspan='2'><a href='adminpanel.php?izbor=DodajL'>DODAJ LINK</a></th></tr>";
$i = 0;
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_linka']."</td>";
echo "<td>".$r['naziv_linka']."</td>";
echo "<td>".$r['putanja']."</td>";
if($r['id_roditelja']!=null)
{
$upit1 = "SELECT naziv_linka FROM linkovi WHERE id_linka=".$r['id_roditelja'];
$rez1 = mysqli_query($konekcija, $upit1);
$r1 = mysqli_fetch_array($rez1);
echo "<td>".$r1['naziv_linka']."</td>";
}
else
{
echo "<td> </td>";
}
echo "<td><a href='adminpanel.php?izbor=IzmenaL&id_linka=".$r['id_linka']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeL&id_linka=".$r['id_linka']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r['id_linka']."</td>";
echo "<td>".$r['naziv_linka']."</td>";
echo "<td>".$r['putanja']."</td>";
if($r['id_roditelja']!=null)
{
$upit1 = "SELECT naziv_linka FROM linkovi WHERE id_linka=".$r['id_roditelja'];
$rez1 = mysqli_query($konekcija, $upit1);
$r1 = mysqli_fetch_array($rez1);
echo "<td>".$r1['naziv_linka']."</td>";
}
else
{
echo "<td> </td>";
}
echo "<td><a href='adminpanel.php?izbor=IzmenaL&id_linka=".$r['id_linka']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeL&id_linka=".$r['id_linka']."'>OBRISI</a></td></tr>";
}
$i++;
}
echo "</table>";
}
if($_REQUEST['izbor']=='DodajL')
{
if(isset($_REQUEST['btnDodajL']))
{
					
					$naziv_linka = $_REQUEST['naziv_linka'];
					$putanja = $_REQUEST['putanja'];
					$regNaziv_linka = "/^([A-z]|[0-9]|\.|\/|\s)*$/";
					$regPutanja = "/^([a-z]|[0-9]|\.|\/|\_)*$/";
					$id_roditelja = $_REQUEST['id_roditelja'];
					$sadrzaj_linka = $_REQUEST['sadrzaj_linka'];
					$greske = array();
					if(!preg_match($regNaziv_linka, $naziv_linka))
					{
						$greske[] = "Naziv linka nije u dobrom formatu.";
					}
					if(!preg_match($regPutanja, $putanja))
					{
						$greske[] = "Putanja nije u dobrom formatu.";
					}
					$upit = "SELECT putanja FROM linkovi";
					$rez = mysqli_query($konekcija, $upit);
					while($r=mysqli_fetch_array($rez))
					{
					if($r['putanja'] == $putanja)
						$greske[] = "Putanja vec postoji.";
					}
					if(count($greske)!=0)
					{
						echo "<div id='ispis'><ul style='list-style:none;'>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						if(is_file($putanja))
						{
							unlink($putanja);
						}
						$file = fopen("$putanja","w+");
						fwrite($file, $sadrzaj_linka);
						fclose($file);
						if($id_roditelja != 0)
						$upit = "INSERT INTO linkovi VALUES('','$naziv_linka','$putanja','$id_roditelja')";
						else
						$upit = "INSERT INTO linkovi VALUES('','$naziv_linka','$putanja', NULL)";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Linkovi\"</script>");
						}
					}
}
else
{
		$upit = "SELECT * FROM linkovi WHERE id_roditelja IS NULL";
		$rez = mysqli_query($konekcija,$upit);
		echo "<form name='formK' method='post' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv linka</td><td><input type='text' name='naziv_linka' /></td></tr>";
		echo "<tr><td>Putanja</td><td><input type='text' name='putanja' /></td></tr>";
		echo "<tr><td>Roditelj</td><td>
		<select name='id_roditelja' >
		<option value='0'>Nema roditelja</option>";
		while($r=mysqli_fetch_array($rez))
		{
		echo "<option value='".$r[id_linka]."'>".$r['naziv_linka']."</option>";
		}
		echo "</select>
		</td></tr>";
		echo "<tr><td>Sadrzaj linka</td><td><textarea cols='20' rows='30' name='sadrzaj_linka'></textarea></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajL'/>";
		echo "<tr><td><input type='submit' name='btnDodajL' value='Dodaj' /></td><td><a href='adminpanel.php?izbor=Linkovi'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaL')
{
if(isset($_REQUEST['btnPromenaL']))
{
					$naziv_linka = $_REQUEST['naziv_linka'];
					$id_linka = $_REQUEST['id_linka'];
					$putanja = $_REQUEST['putanja'];
					$regNaziv_linka = "/^([A-z]|[0-9]|\.|\/|\s)*$/";
					$regPutanja = "/^([a-z]|[0-9]|\.|\/|\#|\_)*$/";
					$id_roditelja = $_REQUEST['id_roditelja'];
					$sadrzaj_linka = $_REQUEST['sadrzaj_linka'];
					$greske = array();
					if(!preg_match($regNaziv_linka, $naziv_linka))
					{
						$greske[] = "Naziv linka nije u dobrom formatu.";
					}
					if(!preg_match($regPutanja, $putanja))
					{
						$greske[] = $regPutanja.'<br/>';
						$greske[] = "Putanja nije u dobrom formatu.";
					}	
					/*$upit = "SELECT putanja FROM linkovi";
					$rez = mysqli_query($konekcija, $upit);
					while($r=mysqli_fetch_array($rez))
					{
					if($r['putanja'] == $putanja)
						$greske[] = "Putanja vec postoji.";
					}*/
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
						if($putanja != '#')
						{
						$file = fopen("$putanja","w+");
						fwrite($file, $sadrzaj_linka);
						fclose($file);
						}
						if($id_roditelja != 0)
						$upit = "UPDATE linkovi SET naziv_linka='$naziv_linka', putanja='$putanja', id_roditelja='".$id_roditelja."' WHERE id_linka='".$id_linka."'";
						else
						$upit = "UPDATE linkovi SET naziv_linka='$naziv_linka', putanja='$putanja', id_roditelja=NULL WHERE id_linka='".$id_linka."'";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Linkovi\"</script>");
						}
					}		
}
else
{
		$id_linka = $_REQUEST['id_linka'];
		$upit = "SELECT * FROM linkovi WHERE id_linka=".$id_linka;
		$rez = mysqli_query($konekcija,$upit);
		$r = mysqli_fetch_array($rez);
		$putanja = $r['putanja'];
		$upit1 = "SELECT * FROM linkovi WHERE id_roditelja IS NULL";
		$rez1 = mysqli_query($konekcija,$upit1);
		echo "<form name='formK' method='post' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv linka</td><td><input type='text' name='naziv_linka' value='".$r['naziv_linka']."'/></td></tr>";
		echo "<tr><td>Putanja</td><td><input type='text' name='putanja' value='".$r['putanja']."'/></td></tr>";
		echo "<tr><td>Roditelj</td><td>
		<select name='id_roditelja' >";
		if($r['id_roditelja']==null)
		echo "<option value='0' selected>Nema roditelja</option>";
		else
		echo "<option value='0'>Nema roditelja</option>";
		while($r1=mysqli_fetch_array($rez1))
		{
		if($r1['id_linka'] == $r['id_roditelja'])
		echo "<option value='".$r1['id_linka']."' selected>".$r1['naziv_linka']."</option>";
		else
		echo "<option value='".$r1['id_linka']."'>".$r1['naziv_linka']."</option>";
		}
		echo "</select>
		</td></tr>";
		if($putanja != '#')
		{
		$file = fopen("$putanja","r+");
		$read_file = @fread($file,filesize("$putanja"));
		fclose($file);
		echo "<tr><td>Sadrzaj linka</td><td><textarea cols='50' rows='40' name='sadrzaj_linka'>";echo htmlspecialchars($read_file); echo"</textarea></td></tr>";
		}
		echo "<input type='hidden' name='izbor' value='IzmenaL'/>";
		echo "<input type='hidden' name='id_linka' value='".$id_linka."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaL' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Linkovi'><input type='button' value='Odustani'/></a></td></tr></table></form><br/><br/>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeL')
{
	$id = $_REQUEST['id_linka'];
	$upit1 = "SELECT * FROM linkovi WHERE id_linka='".$id."'";
	$rez1 = mysqli_query($konekcija, $upit1);
	$r1 = mysqli_fetch_array($rez1);
	unlink($r1['putanja']); 
	$upit = "DELETE FROM linkovi WHERE id_linka=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 header("Location:adminpanel.php?izbor=Linkovi");
	}
}
?>