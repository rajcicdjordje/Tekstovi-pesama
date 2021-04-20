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
			<ul id="meni">
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
			</ul>
		</div>	
		</div>
		
	</div>
	<div id="sredina">
		<div id="sredina1" style="height:670px;">
			<h1 style="text-align:center; padding:10px;">Đorde Rajčić</h1>
			<p style="margin:10px; font-size:20px;">Ja sam Đorđe Rajčić, student Visoke škole za informacione i komunikacione tehnologije.
			Rođen sam u Smederevskoj Palanci 1995. godine, sada trenutno živim u Beogradu.
			Završio sam Mašinsku elektrotehničku školu Gošu, smer Tehničar mehatronike. Trenutno sam na trecoj godini, smera internet tehnologije.</p>
			<img src="slike/22.jpg" width="460" height="500px" style="margin-left:130px;margin-top:10px;float:left;"/>
			<form name="forma" action="autor.php" method="get" style="float:right;margin-right:60px;margin-top:5px;font-size:18px;background-image:url('slike/21.jpg')">
					<h4>Kako vam se sviđa sajt?</h4></br>
					&nbsp<input type="radio" id="Good" name="choice" value="dobar"/> Dobar </br>
					&nbsp<input type="radio" id="Bed" name="choice" value="los"/> Loš </br>
					&nbsp&nbsp<input type="submit" id="glasaj" name="glasaj" value="Glasaj" style="font-size:18px"/></br></br>
					<?php
					@$rez = mysqli_query($konekcija,"SELECT * FROM anketa");
					@$r = mysqli_fetch_array($rez);
					
					echo "&nbsp Dobar: <span id='Good1'>5".$r['dobar']."</span></br></br>";
					echo "&nbsp Loš: <span id='Bed1'>2".$r['los']."</span></br>";
					?>
			</form>
			<?php
		/*	if(isset($_REQUEST['glasaj']) && isset($_SESSION['idU']))
			{
				$glas = $_REQUEST['choice'];
				$upit = "SELECT * FROM korisnici WHERE korisnicko_ime='".$_SESSION['kor_ime']."' AND anketa=1";
				$rez = mysqli_query($konekcija, $upit);
				if(mysqli_num_rows($rez)!=0)
				{
					echo "<p style='padding-left:20px;padding-top:20px;color:#1b1b77;font-size:20px;'>Ostavili ste svoj glas. Nemate vise prava.</p>";
				}
				else
				{
					$upit1 = "UPDATE korisnici SET anketa=1 WHERE korisnicko_ime='".$_SESSION['kor_ime']."'; 
							  UPDATE anketa SET ".$glas."=".$glas."+1  WHERE id_anketa=1;"; 
					$rez1 = mysqli_multi_query($konekcija,$upit1);
					if($rez1)
					{
						echo "Uspesno ste dali svoj glas. Hvala.";
					}
					else
					{
						echo "Greska";
					}
				}
			}*/
			?>
			<div id="polje1">Uspešno ste glasali. Hvala!</div>
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