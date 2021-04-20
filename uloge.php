<?php 
if($_REQUEST['izbor']=='Uloge')
{
$upit = "SELECT * FROM uloge";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:50%;margin:0 auto;font-size:26px'><tr><th>Id uloge</th><th>Naziv uloge</th><th colspan='2'><a href='adminpanel.php?izbor=DodajU'>DODAJ ULOGU</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_uloge']."</td>";
echo "<td>".$r['naziv_uloge']."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaU&id_uloge=".$r['id_uloge']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeU&id_uloge=".$r['id_uloge']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r["id_uloge"]."</td>";
echo "<td>".$r["naziv_uloge"]."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaU&id_uloge=".$r['id_uloge']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeU&id_uloge=".$r['id_uloge']."'>OBRISI</a></td></tr>";  
}
$i++;
}
echo "</table>";
}
if($_REQUEST['izbor']=='DodajU')
{
if(isset($_REQUEST['btnDodajU']))
{
					
					$naziv_uloge = $_REQUEST['naziv_uloge'];
					$regNaziv_uloge = "/^[A-z]{2,}([A-z]|[0-9])*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_uloge, $naziv_uloge))
					{
						$greske[] = "Naziv uloge nije u dobrom formatu.";
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
						$upit = "INSERT INTO uloge VALUES('','$naziv_uloge')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Uloge\"</script>");
						}
					}
}
else
{
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv uloge</td><td><input type='text' name='naziv_uloge' /></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajU'/>";
		echo "<tr><td><input type='submit' name='btnDodajU' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Uloge'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaU')
{
if(isset($_REQUEST['btnPromenaU']))
{
					$naziv_uloge = $_REQUEST['naziv_uloge'];
					$id_uloge = $_REQUEST['id_uloge'];
					$regNaziv_uloge = "/^[A-z]{2,}([A-z]|[0-9]|\s)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_uloge, $naziv_uloge))
					{
						$greske[] = "Naziv uloge nije u dobrom formatu.";
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
						$upit = "UPDATE uloge SET naziv_uloge='$naziv_uloge' WHERE id_uloge=".$id_uloge;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Uloge\"</script>");
						}
					}		
}
else
{
		$id_uloge = $_REQUEST['id_uloge'];
		$upit = "SELECT * FROM uloge WHERE id_uloge=".$id_uloge;
		$rez = mysqli_query($konekcija,$upit);
		$r = mysqli_fetch_array($rez);
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv uloge</td><td><input type='text' name='naziv_uloge' value='".$r['naziv_uloge']."'/></td></tr>";
		echo "<input type='hidden' name='izbor' value='IzmenaU'/>";
		echo "<input type='hidden' name='id_uloge' value='".$id_uloge."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaU' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Uloge'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeU')
{
	$id = $_REQUEST['id_uloge'];
	$upit = "DELETE FROM uloge WHERE id_uloge=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Uloge\"</script>");
	}
}
?>