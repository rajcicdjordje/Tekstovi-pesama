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
</head>
<body>
<?php
include("konekcija.inc");
?>
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
		<div id="forma9" style="position:absolute;left:30px;width:968px;top:40px;min-height:360px;max-height:1100px;">
				
				<div id="login">
					<h2>Prijavljivanje</h2><br/>
					<form id="form3" action="<?php echo $_SERVER['PHP_SELF'].'?btnSubmit=1'?>" method="post">
						<fieldset>
							<legend>Prijava</legend>
							<table cellpadding="20" cellspacing="20">
								<tr>
									<td>Korisničko ime:</td>
									<td><input type="text" name="tbKorisnickoIme" id="tbKorisnickoIme2" placeholder="Unesite korisničko ime"/></td>
									<td id="kime3">Primer: Marko123</td>
								</tr>
								<tr>
									<td>Lozinka:</td>
									<td><input type="password" name="tbLozinka" id="tbLozinka2" placeholder="Unesite lozinku"/></td>
									<td id="lozinka2">Primer: Natasa34</td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" value="PRIJAVI SE" class="formbutton" onClick="provera4();"/>
									</td>
								</tr>
							</table>
						</fieldset>
					</form>
					<?php 
						if(isset($_REQUEST['btnSubmit']))
						{
						$korIme = $_REQUEST['tbKorisnickoIme'];
						$lozinka = $_REQUEST['tbLozinka'];
						$regKorIme = "/^[A-z]{3,}([A-z]|[0-9])*$/";
						$regLozinka = "/^[A-z]{1}([A-z]|[0-9])*$/";
						$greske = array();
						if(!preg_match($regKorIme,$korIme))
						{
							$greske[] = "Neispravno korisnicko ime.";
						}
						if(!preg_match($regLozinka,$lozinka))
						{
							$greske[] = "Neispravna lozinka.";
						}
						else
						{
							$lozinka = md5($lozinka);
						}
						if(count($greske)!=0)
						{
							echo "<ul  style='list-style-type:none;'>";
							foreach($greske as $g)
							{
								echo "<li>$g</li>";
							}
							echo "</ul>";
						}
						else
						{
							$upit = "SELECT * FROM korisnici k INNER JOIN korisnici_uloge ku ON k.id_korisnika=ku.id_korisnika INNER JOIN uloge u ON ku.id_uloge=u.id_uloge WHERE k.korisnicko_ime='$korIme' AND k.lozinka='$lozinka' AND k.verifikacija=1 ";
							$rez = mysqli_query($konekcija,$upit);
							if(mysqli_num_rows($rez)==0)
							{
								$greske[] = "Korisnik sa unetim korisnickim imenom i lozinkom ne postoji ili niste potvrdili svoj profil. ";
								if(count($greske)!=0)
								{
								echo "<ul style='list-style-type:none;'>";
								foreach($greske as $g)
								{
									echo "<li>$g</li>";
								}
								echo "</ul>";
								}
							}
							else
							{
							$korisnik = mysqli_fetch_array($rez);
							
							$korisnickoIme = $korisnik['korisnicko_ime'];
							
							$ime = $korisnik['ime'];
							
							$prezime = $korisnik['prezime'];
							
							$naziv_uloge = $korisnik['naziv_uloge'];
							
							$id_uloge = $korisnik['id_uloge'];
							
							$_SESSION['idU'] = $id_uloge;
							
							$_SESSION['kor_ime'] = $korisnickoIme;
							
							//setcookie($korisnickoIme, $id_uloge, time() + (86400*30), "/");
							
							switch($naziv_uloge)
							{
								case 'admin':
									print("<script type=\"text/javascript\">location.href=\"index.php\"</script>");
									break;
								case 'korisnik':
									print("<script type=\"text/javascript\">location.href=\"index.php\"</script>");
									break;
							}
						}
						include('zatvori.inc');
						}
						}
					?>
					<div id="ispis2">Uspešno ste se prijavili.</div>
				</div>
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
</body>
</html>