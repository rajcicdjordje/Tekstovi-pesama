<?php 
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title>Tekstovi pesama</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="slike/grb.png">
	<META name="keywords" content="palanka, smederevska, glibovac, kusadak, selevac, azanja">
	<META name="description" content="Ovaj sajt je posvecen svim Palančanima koji vole ovaj grad i koji uživaju u njemu!!!">
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="Java1.js"></script>
	<script type="text/javascript" src="ajax1.js"></script>
	<link rel="stylesheet" href="jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="gallery.js"></script>
	<script type="text/javascript" src="jquery2.js"></script>
	<script type="text/javascript" src="search.js"></script>
	<link rel="stylesheet" type="text/css" href="css.css"/>
</head>
<?php 
include('konekcija.inc');
?>
<body>
<div id="pozadina">
	<div id="heder">
		<div id="heder1">
		<div id="hederGore">
			<ul id="ul1">
				<li><a href="autor.php">Autor</a></li> 
				<li><a href="dokumentacija.pdf">Dokumentacija</a></li> 
				<li><a href="sitemap.xml">Mapa sajta</a></li>
			</ul>
			<ul id="ul2">
				<?php 
				if(!isset($_SESSION['idU']))
				{
				echo "<li><a href='prijava.php'>Prijavi se</a></li>";
				}
				?>
				<li><a href="registracija.php">Registracija</a></li>
				<?php 
				if(isset($_SESSION['idU']))
				{
					if($_SESSION['idU']==2)
					{
					echo "<li><a href='adminpanel.php'>Admin panel</a></li>";
					}
					echo "<li><a href='logout.php'>Logout</a></li>";
					echo "<li><a href='#'>".$_SESSION['kor_ime']."</a></li>";
				}
				?>
			</ul>
		</div>
		<div id="hederSredina">
		<div id="naziv">
			<h1><a href="index.php">Tekstovi pesama</a></h1>
			<h2>Republika Srbija</h2>
		</div>
		<div id="mreze">
			<ul>
				<li><a href="http://www.facebook.com"><img src="slike/facebook.png" alt="facebook" width="35px" height="35px"/></a></li>
				<li><a href="http://www.twitter.com"><img src="slike/twitter.png" alt="twitter" width="35px" height="35px"/></a></li>
				<li><a href="http://www.instagram.com"><img src="slike/instagram.png" alt="instagram" width="35px" height="35px"/></a></li>
				<li><a href="http://www.google.com"><img src="slike/google.png" alt="google" width="35px" height="35px"/></a></li>
			</ul>
		</div>
		</div>
		<div id="menu">
			<ul id="meni">
				<li><a href="index.php">Početna</a></li>
				
			</ul>
		</div>	
		<div id="pretraga">
			<form action="#" method="get">
			<input type="text" id="text1" placeholder="Pretraga..."/> 
			<input type="button" id="pretraga1" value=" "/>
			</form>
		</div>
		</div>
		
	</div>
	<div id="sredina">
		<div id="rezultat">
		<p id="naslovId"></p>
		<p id="opisId"></p>
		<p id="linkId"></p></br>
		<input type="button" id="kraj" value="Zavrsetak pretrage" />
		</div>
		<div id="sredina1">
		<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" name="form" enctype="multipart/form-data">
	     <table style="width:500px; margin:0 auto;">
		  <tr>
			    <td>Izaberite galeriju za prikaz:</td>
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
				    <input type="submit" value="Prikazi" class="button" name="btnPrikazi" />
				</td>
			 </tr>
		 </table>
	  
		</form>
		<div id="galerija">
		<?php
			if(isset($_REQUEST['btnPrikazi']))
			{
				$idGalerije = $_REQUEST['ddlGalerija'];
				
				$upit_ispis = "SELECT * FROM slike WHERE id_galerije=".$idGalerije;
				
				$rez_ispis = mysqli_query($konekcija,$upit_ispis);
				
				$dir_velike = "slike/";
				
				$dir_male = "slike/male_slike/";
				
				if(mysqli_num_rows($rez_ispis) == 0)
				{
					print "Trenutno nema slika za izabranu galeriju!";
				}
				else
				{	
					$broj_strana = ceil(mysqli_num_rows($rez_ispis)/12);
					if
					$slike = array();
					while($r = mysqli_fetch_array($rez_ispis))
					{
						$slike[] = $r;
					}
					
					$broj_redova = count($slike)/4;
					
					for($i = 0, $k = 0; $i < $broj_redova; $i++, $k += 4)
					{
						print "<ul>";
						
						for($j=$k; $j<$k+4; $j++)
						{
							if(isset($slike[$j]))
							{
								print "<li>";
								print "<a class='fancybox' rel='group' href='".$dir_velike.$slike[$j]['slika']."' title='".$slike[$j]['naziv_slike']."'>";
								print "<img src='".$dir_male.$slike[$j]['slika']."' alt='".$slike[$j]['naziv_slike']."'/></a>";

								print "</li>";

							}
						}
						print "</ul>";
					}
					
				}
			}
		?>
		</div>
		</div>	
	</div>
	<div id="futer">
		<div id="futer1">
			<ul>
				<li class="li_border"><a href="dokumentacija.pdf">Dokumentacija</a></li>
				<li class="li_border"><a href="autor.php">Autor</a></li>
				<li class="li_border"><a href="sitemap.xml">Sitemap</a></li>
				<li><a href="rss.xml"><img src="slike/RSS_button_1021.png" width="30px" height="30px"/></a></li>
			</ul>
			<p>&copy; 2017 Beograd | Design by <a href="https://facebook.com/djolerajcic"> Đorde Rajčić</a></p>
		</div>
	</div>
</div>
<?php 
include('zatvori.inc');
?>
</body>
</html>