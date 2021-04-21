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
	<META name="keywords" content="tekstovi, pesme, muzika, pop, folk, narodna">
	<META name="description" content="Ovaj sajt je namenjen iskljucivo za dodavanje i pretragu tekstova pesama muzike naseg kraja!!!">
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="Java1.js"></script>
	<link rel="stylesheet" href="jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="gallery.js"></script>
	<link rel="stylesheet" type="text/css" href="css.css"/>
</head>
<?php 
include('konekcija.inc');
include('funkcije.inc');
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
		<div id="pretraga">
			<form action="search.php" method="get">
			<input type="text" id="text1" name="text1" placeholder="Pretraga..."/> 
			<input type="submit" id="pretraga1" name='btnSubmit' value=" "/>
			</form>
		</div>
		<div id="menu">
			<?php 
			$upit = "SELECT * FROM linkovi WHERE id_roditelja IS NULL";
			$rez = mysqli_query($konekcija,$upit);
			if(mysqli_num_rows($rez)!=0)
			{	
				$k = 0;
				echo "<ul>";
				while($r=mysqli_fetch_array($rez))
				{	
					$k++;
					$id = $r['id_linka'];
					$upit1 = "SELECT * FROM linkovi WHERE id_roditelja=".$id;
					$rez1 = mysqli_query($konekcija,$upit1);
					if(mysqli_num_rows($rez1)!=0)
					{
						echo "<li id='pod".$k."'><a href='{$r['putanja']}'>{$r['naziv_linka']}</a>";
						echo "<ul id='podmeni".$k."'>";
						while($r1=mysqli_fetch_array($rez1))
						{	
							echo "<li><a href='{$r1['putanja']}'>{$r1['naziv_linka']}</a>";
							
							echo "</li>";
						}
						echo "</ul></li>";
					}
					else
					{
						echo "<li><a href='{$r['putanja']}'>{$r['naziv_linka']}</a>";
						echo "</li>";
					}

				}
				echo "</ul>";
			}
			?>
		</div>	
		</div>
		
	</div>
	<div id="sredina">
		<div id="sredina1">
		<?php 
		if(isset($_REQUEST['id']))
		{
			$upit1 = "SELECT * FROM tekstovi WHERE id_teksta=".$_REQUEST['id'];
			$rez1 = mysqli_query($konekcija,$upit1) or die(mysqli_error($konekcija));
			$r1 = mysqli_fetch_array($rez1);
			echo "<p style='padding-top:20px;font-size:35px;' align='center'>".$r1['izvodjac']." - ".$r1['naziv_pesme']."</p></br></br></br>";
			echo "<div id='objedinjeno'><div id='pesma_tekst'>".$r1['tekst_pesme']."<br/><br/><b><p style='color:#3434c3;' align='center'>Hvala ".$r1['korisnicko_ime']."</p></b><i>...</i></div>";
			
			if($r1['link']!=null)
			{	
			//echo "<div id='link_pesme'><iframe width='420' height='315' src='".substr(urldecode($r1['link']),0,24)."embed/".substr(urldecode($r1['link']),32)."' allowfullscreen></iframe></div></div>";
			//echo "<div id='link_pesme'><embed width='420' height='315' src='".substr(urldecode($r1['link']),0,24)."embed/".substr(urldecode($r1['link']),32)."' allowfullscreen='true'></div></div>";
				if(substr(urldecode($r1['link']),0,17)=='https://youtu.be/')
				echo "<div id='link_pesme'><iframe width='420' height='315' src='https://www.youtube.com/embed/".substr(urldecode($r1['link']),17)."' allowfullscreen></iframe></div>";
				else
				echo "<div id='link_pesme'><iframe width='420' height='315' src='".substr(urldecode($r1['link']),0,24)."embed/".substr(urldecode($r1['link']),32)."' allowfullscreen></iframe></div></div>";
			
			}
		}
		else
		{
		?>
		<h1 style='padding-top:10px;text-align:center;'>Najbolji tekstovi narodnih pesama</h1>
		<?php 
			
			$limit=5;
				 $strana=@$_REQUEST['p'];
				 if($strana=='')
				 {
				  $strana=1;
				  $start=0;
				 }
				 else
				 {
				  $start=$limit*($strana-1);
				 }
				$rez1=mysqli_query($konekcija, "SELECT * FROM tekstovi t JOIN zanrovi z ON t.id_zanra=z.id_zanra WHERE z.naziv_zanra='Narodna' AND verifikacija=1")  or die(mysqli_error($konekcija));
				$red1=mysqli_num_rows($rez1);
				$broj_strana=ceil($red1/$limit);
				
			if(mysqli_num_rows($rez1)==0)
			{
				echo "<p><h2>Trenutno u ovom zanru nemamo dostupnih tekstova. Molimo dodajte tekstove <a href='dodaj_tekst.php'>ovde</a></h2></p>";
			}
			else
			{
				$upit = "SELECT * FROM tekstovi t JOIN zanrovi z ON t.id_zanra=z.id_zanra WHERE z.naziv_zanra='Narodna' AND verifikacija=1 LIMIT ".$start.",".$limit;
				$rez = mysqli_query($konekcija,$upit);
				echo "<div id='pesme'>";
				while($r=mysqli_fetch_array($rez))
				{
					echo "<div class='pesma' >";
					echo "<h2><a href='".strtolower($r['naziv_zanra']).".php?id=".$r['id_teksta']."'>".$r['izvodjac']." - ".$r['naziv_pesme']."</a></h2>";
					$t = $r['tekst_pesme'];
					$t1 = array();
					$t1 = explode(" ", $t);
					for($i=0;$i<=15;$i++)
					{
					if($i==7)
					{
					@$t2 .= $t1[$i];
					}
					else
					{
					@$t2 .= $t1[$i]." ";
					}
					}
					echo @$t2;
					unset($t);
					unset($t1);
					unset($t2);
					echo "</div>";
				}
				echo "</div>";
				pagination_songs($strana,$broj_strana,'narodna');
			}
			}
		?>
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