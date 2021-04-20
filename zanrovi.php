<?php 
if($_REQUEST['izbor']=='Zanrovi')
{
$upit = "SELECT * FROM zanrovi";
$rez = mysqli_query($konekcija,$upit);
echo "<table id='tableK' name='tableK' style='width:50%;margin:0 auto;font-size:26px'><tr><th>Id zanra</th><th>Naziv zanra</th><th colspan='2'><a href='adminpanel.php?izbor=DodajZ'>DODAJ ZANR</a></th></tr>";
while($r=mysqli_fetch_array($rez))
{
if($i%2==0)
{
echo "<tr><td>".$r['id_zanra']."</td>";
echo "<td>".$r['naziv_zanra']."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaZ&id_zanra=".$r['id_zanra']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeZ&id_zanra=".$r['id_zanra']."'>OBRISI</a></td></tr>";
}
else
{
echo "<tr style='color:red;background:grey;'><td>".$r["id_zanra"]."</td>";
echo "<td>".$r["naziv_zanra"]."</td>";
echo "<td><a href='adminpanel.php?izbor=IzmenaZ&id_zanra=".$r['id_zanra']."'>IZMENI</a></td>";
echo "<td><a href='adminpanel.php?izbor=BrisanjeZ&id_zanra=".$r['id_zanra']."'>OBRISI</a></td></tr>";  
}
$i++;
}
echo "</table>";
}
if($_REQUEST['izbor']=='DodajZ')
{
if(isset($_REQUEST['btnDodajZ']))
{
					
					$naziv_zanra = $_REQUEST['naziv_zanra'];
					$regNaziv_zanra = "/^[A-z]{2,}([A-z]|[0-9])*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_zanra, $naziv_zanra))
					{
						$greske[] = "Naziv zanra nije u dobrom formatu.";
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
						$upit = "INSERT INTO zanrovi VALUES('','$naziv_zanra')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Zanrovi\"</script>");
						}
					}
}
else
{
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv zanra</td><td><input type='text' name='naziv_zanra' /></td></tr>";
		echo "<input type='hidden' name='izbor' value='DodajZ'/>";
		echo "<tr><td><input type='submit' name='btnDodajZ' value='Dodaj'/></td><td><a href='adminpanel.php?izbor=Zanrovi'><input type='button' value='Odustani'/></a></td></tr></table></form>";
		
}
}
if($_REQUEST['izbor']=='IzmenaZ')
{
if(isset($_REQUEST['btnPromenaZ']))
{
					$naziv_zanra = $_REQUEST['naziv_zanra'];
					$id_zanra = $_REQUEST['id_zanra'];
					$regNaziv_zanra = "/^[A-z]{2,}([A-z]|[0-9]|\s)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regNaziv_zanra, $naziv_zanra))
					{
						$greske[] = "Naziv zanra nije u dobrom formatu.";
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
						$upit = "UPDATE zanrovi SET naziv_zanra='$naziv_zanra' WHERE id_zanra=".$id_zanra;
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Zanrovi\"</script>");
						}
					}		
}
else
{
		$id_zanra = $_REQUEST['id_zanra'];
		$upit = "SELECT * FROM zanrovi WHERE id_zanra=".$id_zanra;
		$rez = mysqli_query($konekcija,$upit);
		$r = mysqli_fetch_array($rez);
		echo "<form name='formK' method='get' action='adminpanel.php'><table name='tableIK' id='tableIK' style='margin:0 auto;'>";
		echo "<tr><td>Naziv zanra</td><td><input type='text' name='naziv_zanra' value='".$r['naziv_zanra']."'/></td></tr>";
		echo "<input type='hidden' name='izbor' value='IzmenaZ'/>";
		echo "<input type='hidden' name='id_zanra' value='".$id_zanra."'/>";
		echo "<tr><td><input type='submit' name='btnPromenaZ' value='Promeni'/></td><td><a href='adminpanel.php?izbor=Zanrovi'><input type='button' value='Odustani'/></a></td></tr></table></form>";
	
}
}
if($_REQUEST['izbor']=='BrisanjeZ')
{
	$id = $_REQUEST['id_zanra'];
	$upit = "DELETE FROM zanrovi WHERE id_zanra=".$id;
	$rez = mysqli_query($konekcija, $upit);
	if($rez)
	{
	 print("<script type=\"text/javascript\">location.href=\"adminpanel.php?izbor=Zanrovi\"</script>");
	}
}
?>