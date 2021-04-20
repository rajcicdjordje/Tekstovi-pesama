<html>
<head></head>
<?php
	include("konekcija.inc");
?>
<body>

<?php
	$upit_g = "SELECT tekst_pesme FROM tekstovi WHERE id_teksta=5";
	$rez_g = mysqli_query($konekcija,$upit_g) or die("Greska prilikom iscitavanja galerija!");
	
	while($r=mysqli_fetch_array($rez_g))
	{
		echo "<div id='tekst' align='center' style='width:360px;height:500px;'>{$r['tekst_pesme']}</div>";
	}
	
?>

<?php
include("zatvori.inc");
?>
</body>
</html>