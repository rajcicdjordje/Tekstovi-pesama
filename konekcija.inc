<?php
	$konekcija = mysqli_connect("localhost", "root", "") or die("Konekcija se serverom baze podataka nije uspela!");
	
	$izbor_baze = mysqli_select_db($konekcija, "sajt")or die("Greska prilikom izbora baze!");
	
	mysqli_set_charset($konekcija,"utf8");
?>