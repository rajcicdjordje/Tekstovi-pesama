<?php 
ini_set('session.cookie_lifetime',864000);
session_start();

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
		<link rel="stylesheet" type="text/css" href="css1.css"/>
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
		<div class="container-left">
		<h2 align="center">Muzicke vesti</h2><br>
		<p style="color:white">
 		Za Marinu Viskovic kazu da je najlepsa i najzgodniha pevacica na srpskoj estradi, sto je i dokazala u Crnoj Gori sa atraktivnim bikinijem.
Pevacica je uzivala na plazi, kao i ostali sto su uzivali u pogledu na nju.
 Prija joj morska voda , sve oci su bile uperene u nju, ali ona se nije obazirala na to, vec se opustala i caskala sa ljudima. 
Telefon je bio neizostavan deo odmora jer gotovo ga nije ispustala iz ruke.</p>
<img style="width:640px" src="slike/index/marina.jpg" alt="Marina | Tekstovi pesama">
<br><br><br>
<p style="color:white">
Ivana Maksimovic objavila je fotografiju s vencanja.
Tacno mesec dana nakon sto se zavetovala kosarkasu Danilu, Ivana Maksimovic je objavila fotografiju sa vencanja.
Srpska sampionka se udala za Danila Andjusica, krajem juna tacno mesec dana nakon sto je izgovorila da. Jedno drugom su rekli da i zavetovali su se na vecnu ljubav. </p>
<br>
<img style="width:640px; height:325.5px" src="slike/index/vencanje2.jpg" alt="Marina | Tekstovi pesama">
		</div>
		<div class="container-right">
		<h2 align="center">
		O sajtu
		</h2>
		<br>
		<p style="color:white">
		Na nasem sajtu mozete pronaci najveci izbor tekstova za pesme, ako zelite da upisete vase primedbe i sugestije morate se ulogovati na nas sajt. Kad se ulogujete mozete ostaviti neki tekst pesme po vasem izboru. Nas sajt sluzi za domacu muziku tako da strane pesme ne mozete objaviti jer nece biti prihvacene.
		</p><br>
		<img style="width:100%; " src="slike/index/dobrodosli1.jpg" alt="Marina | Tekstovi pesama"><br>
		<form action="#" method="post" name="forma" id="forma">
					<fieldset>
					<p>Ocenite nas sajt.</p>
					<input type="radio" name="e" id="rVDobar" /> Vrlo dobar </br>
					<input type="radio" name="e" id="rDobar" /> Dobar 2</br>
					<input type="radio" name="e" id="rLos" /> Loš <br>
					<button type="submit" style="background-color: green; padding: 6px;">Pošalji</button>
					
					</fieldset>
					</form>
					<img style="width:100%; " src="slike/index/harmonika.jpg" alt="Marina | Tekstovi pesama">
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