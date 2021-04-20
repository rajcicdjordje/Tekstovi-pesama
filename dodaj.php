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
		
			<?php 
			if(!isset($_SESSION['idU']))
			{
				echo "<div id='sredina1'>";
				echo "<p><h2 > Morate da se prijavite pa tek onda da dodate pesmu <a href='prijava.php'>prijava</a>,<br/>a ukoliko nemate nalog na ovom sajtu prvo se registrujte <a href='registracija.php'>registracija</a>. Prijatno! </h2></p>";
			}
			else
			{
				echo "<div id='sredina1' style='height:1300px;'>";
			?>
			<div class="forma">
			
				<div id="registracija">
					<h2>Napravite ovaj sajt boljim<br/> i unesite nove tekstove pesama</h2><br/>
					<form id="form4" name="form4" action="<?php echo $_SERVER['PHP_SELF']."?btnSubmit=1"; ?>" method="POST">
						<fieldset>
							<legend>Dodaj tekst</legend>
							<table cellpadding="20" cellspacing="20">
								<tr>
									<th colspan="2" align="center">Dodavanje tekstova</th>
								</tr>
								<tr>
									<td>Izvođač pesme:</td>
									<td><input type="text" name="izvodjac" id="izvodjac" autofocus /></td>
								</tr>
								<tr id="izvodjac1">
									<td  colspan="2">Morate uneti izvođača.</td>
								</tr>
								<tr>
									<td>Naziv pesme:</td>
									<td><input type="text" name="naslov" id="naslov" /></td>
								</tr>
								<tr id="naslov1">
									<td colspan="2">Morate uneti naslov pesme.</td>
								</tr>
								<tr>
									<td>Link pesme(Ne morate uneti):</td>
									<td><input type="text" name="link" id="link" /></td>
								</tr>
								<tr>
									<td>Žanr pesme:</td>
									<td><select name="zanr" id="zanr" style="width: 160px;">
									<option value="0">Izaberite žanr...</option>
									<?php
									$upit = "SELECT * FROM zanrovi";
									$rez = mysqli_query($konekcija, $upit);
									if(mysqli_num_rows($rez))
									{
										while($r=mysqli_fetch_array($rez))
										{
											echo "<option value='{$r['id_zanra']}'>{$r['naziv_zanra']}</option>";
										}
									}
									?>
									</select></td>
								</tr>
								<tr id="zanr1">
									<td colspan="2">Morate izabrati žanr.</td>
								</tr>
								<tr>
									<td colspan="2">Tekst pesme:</td>					
								</tr>
								<tr>
									<td colspan="2"><textarea name="tekst2" id="tekst2" rows="24" cols="38"></textarea><td>
								</tr>
								<tr id="tekst1">
									<td colspan="2">Morate uneti tekst pesme.</td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" value="Dodaj tekst" name="btnSubmit" id="btnSubmit1" class="formbutton" onClick="provera5()"/>
										<input type="reset" value="Poništi" class="formbutton"/>
										<input type="hidden" name="hidden" />
									</td>
								</tr>
							</table>
						</fieldset>
					</form>
				
				</div>
		<?php
		}
		?>
		</div>
			<?php 
				if(isset($_REQUEST['btnSubmit']))
				{
				$izvodjac = $_REQUEST['izvodjac'];
				$naslov = $_REQUEST['naslov'];
				$tekst2 = nl2br($_REQUEST['tekst2']);
				$tekst = mysqli_real_escape_string($konekcija,$tekst2);
				$zanr = $_REQUEST['zanr'];
				$greske = array();
				if($_REQUEST['link']!="")
				{
					$link =  mysqli_real_escape_string($konekcija, urlencode($_REQUEST['link']));
				}
				else
				{
					$link = 'NULL';
				}
				
				if($izvodjac=="")
				{
					$greske[] = "Morate uneti izvođača.";
				}
				if($naslov=="")
				{
					$greske[] = "Morate uneti naslov pesme.";
				}
				if($tekst=="")
				{
					$greske[] = "Morate uneti tekst pesme.";
				}
				if($zanr=="0")
				{
					$greske[] = "Morate izabrati zanr.";
				}
				if(count($greske)!=0)
				{
					echo "<ul>";
					foreach($greske as $g)
					{
						echo "<li>$g</li>";
					}
					echo "</ul>";
				}
				else
				{
					$korisnik = $_SESSION['kor_ime'];
					$upit = "INSERT INTO tekstovi VALUES('','$izvodjac','$naslov','$tekst','$link','$zanr','$korisnik','0')";
					$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
					if($rez)
					{
						echo "<div id='ispis1'>Vaš uneti tekst će što pre biti proveren i uskoro će se naći u kolekciji pesama.</div>";
					}
				}
				}
			?>
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