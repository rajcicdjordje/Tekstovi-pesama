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
		
		<div id="sredina1" style="height:890px;">
		<div class="forma">
				<div id="registracija">
					<h2>Registrujte se da biste <br/>postavljali tekstove pesama...</h2><br/>
					<form id="form2" name="form2" action="<?php echo $_SERVER['PHP_SELF']."?btnSubmit=1"; ?>" method="POST">
						<fieldset>
							<legend>Lični podaci</legend>
							<table cellpadding="20" cellspacing="20">
								<tr>
									<th colspan="2" align="center">Registracija korisnika</th>
								</tr>
								<tr>
									<td>Ime:</td>
									<td><input type="text" name="tbIme" id="tbIme" autofocus /></td>
								</tr>
								<tr id="ime">
									<td  colspan="2">Primer: Marko</td>
								</tr>
								<tr>
									<td>Prezime:</td>
									<td><input type="text" name="tbPrezime" id="tbPrezime" /></td>
								</tr>
								<tr  id="prezime">
									<td colspan="2">Primer: Markovic</td>
								</tr>
								<tr>
									<td>Korisničko ime:</td>
									<td><input type="text" name="tbKorisnickoIme" id="tbKorisnickoIme" onKeyUp="proveraKorIme(this)" onChange="proveraKorIme(this)"/></td>									
								</tr>
								<tr id="kime">
									<td id="kime2" colspan="2">Primer: Marko123</td>
								</tr>
								<tr>
									<td>E-pošta:</td>
									<td><input type="email" name="tbEmail" id="tbEmail" onKeyUp="proveraEmail(this)" onChange="proveraEmail(this)"/></td>
								</tr>
								<tr id="email">
									<td id="email2" colspan="2">Primer: Sima123@hotmail.com</td>
								</tr>
								<tr>
									<td>Lozinka:</td>
									<td><input type="password" name="tbLozinka" id="tbLozinka"/></td>
								</tr>
								<tr id="lozinka">
									<td colspan="2">Primer: Natasa34</td>
								</tr>
								<tr>
									<td>Lozinka ponovo:</td>
									<td><input type="password" name="tbLozinkaPonovo" id="tbLozinka1"/></td>
								</tr>
								<tr id="lozinka1">
									<td colspan="2">Lozinke moraju biti iste.</td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" value="REGISTRACIJA" name="btnSubmit" class="formbutton" onClick="provera3();"/>
										<input type="reset" value="PONIŠTI" class="formbutton"/>
										<input type="hidden" name="hidden" />
									</td>
								</tr>
							</table>
						</fieldset>
					</form>
				
				</div>
					<?php 
					if(isset($_REQUEST['btnSubmit']))
					{
					$ime = $_REQUEST['tbIme'];
					$prezime = $_REQUEST['tbPrezime'];
					$korisnicko_ime = $_REQUEST['tbKorisnickoIme'];
					$email = $_REQUEST['tbEmail'];
					$lozinka = $_REQUEST['tbLozinka'];
					$regIme = "/^[A-Ž]{1}[a-ž]{2,14}$/";
					$regPrezime = "/^[A-Ž]{1}[a-ž]{3,17}$/";
					$regEmail = "/^(\w+[\-\.])*\w+@(\w+\.)+[A-Za-z]+$/";
					$regKorisnickoIme = "/^[A-ž]{3,}([A-ž]|[0-9])*$/";
					$regLozinka = "/^[A-ž]{1}([A-ž]|[0-9]|\!|\?|\_)*$/";
					$k = 0;
					$greske = array();
					if(!preg_match($regIme, $ime))
					{
						$greske[] = "Ime nije u dobrom formatu.";
					}
					if(!preg_match($regPrezime, $prezime))
					{
						$greske[] = "Prezime nije u dobrom formatu.";
					}
					if(!preg_match($regEmail, $email))
					{
						$greske[] = "Email nije u dobrom formatu.";
					}
					if(!preg_match($regKorisnickoIme, $korisnicko_ime))
					{
						$greske[] = "korisnicko ime nije u dobrom formatu.";
					}
					
					if(!preg_match($regLozinka, $lozinka))
					{
						$greske[] = "Lozinka nije u dobrom formatu.";
					}
					else
					{
						$lozinka = md5($lozinka);
					}
					if(count($greske)!=0)
					{
						echo "div id='ispis'><ul>";
						foreach($greske as $g)
						{
						echo "<li>$g</li>";
						}
						echo "</ul></div>";
					}
					else
					{
						$upit = "INSERT INTO korisnici VALUES('','$ime','$prezime','$korisnicko_ime','$lozinka','$email','0')";
						$rez = mysqli_query($konekcija,$upit) or die (mysqli_error($konekcija));
						if($rez)
						{
							$mail = mail($email,"Potvrda","Molimo potvrdite ovim linkom http://tekstovi-pesama.eu3.biz/potvrda.php?email=$email .");
							if($mail)
							{
								echo "<div id='ispis' style='display:none;width:450px;height:50px;background-color:#00806E;border:3px dashed red;position:absolute;top:542px;left:0px;font-size:26px;color:red;'>Uspešno ste se registrovali. Aktivacioni link Vam je poslat na mejl adresu: $email. Prijatno!</div>";
							}
							else
							{
							echo "<div id='ispis' style='display:none;width:450px;height:50px;background-color:#00806E;border:3px dashed red;position:absolute;top:542px;left:0px;font-size:26px;color:red;'>Uspešno ste se registrovali. Aktivacioni link Vam nije poslat na mejl adresu: $email. Prijatno!</div>";

							}
										}
					}
					}
					include('zatvori.inc');
					
					?>
				
				<br/>
				
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