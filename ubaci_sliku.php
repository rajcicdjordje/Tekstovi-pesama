<html>
<head></head>
<?php
	include("konekcija.inc");
	include("funkcija_male_slike.inc");
?>
<body>
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
			    <td colspan="2" align="center">
				    <input type="submit" value="Postavi" class="button" name="btnPostavi" />
				</td>
			 </tr>
		 </table>
	  
	  </form>
<?php
if(isset($_REQUEST['btnPostavi']))
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
				include("zatvori.inc");
			}
		}
		else
		{
			$greske[] = "Nije dozvoljen nijedan tip fajla sem jpg/jpeg ili png!";
		}
		
		
	}
?>
</body>
</html>