/* drop-down meni */
$(document).ready(function(){
	$('#futer1 ul li:last').css('paddingTop','3px');
	$('#d1').hide();
	$('#podmeni1').hide();
	$('#podmeni2').hide();
	$('#polje').hide();
	$('#pod1').hover(function(){
		$('#podmeni1').stop(true,true).slideDown();
	},
	function(){
		$('#podmeni1').stop(true,true).hide();
	});
	$('#pod2').hover(function(){
		$('#podmeni2').stop(true,true).slideDown();
	},
	function(){
		$('#podmeni2').stop(true,true).hide();
	});
	$('#d').hover(function(){
		$('#d1').stop(true,true).slideDown();
	},
	function(){
		$('#d1').stop(true,true).hide();
	});
	
})
/* Registracija */
function provera3(){
var regIme = /^[A-Z]{1}[a-z]{2,14}$/;
var regPrezime = /^[A-Z]{1}[a-z]{3,17}$/;
var regEmail = /^(\w+[\-\.])*\w+@(\w+\.)+[A-Za-z]+$/;  /*/^([A-z]{1})*([a-z][0-9])+@[a-z]+\.([a-z]+)*\.[a-z]{2,}$/;*/
var regKIme = /^[A-z]{3,}([A-z]|[0-9])*$/;
var regLozinka = /^[A-z]{1}([A-z]|[0-9])*$/;

var ime = document.getElementById('tbIme');
var prezime = document.getElementById('tbPrezime');
var email = document.getElementById('tbEmail');
var lozinka = document.getElementById('tbLozinka');
var lozinka1 = document.getElementById('tbLozinka1');
var KIme = document.getElementById('tbKorisnickoIme');
var k = 0;
if(!ime.value.match(regIme)){
	ime.style.border = "1px solid red";
	document.getElementById('ime').style.display = "block";
}
else
{
	ime.style.border = "none";
	document.getElementById('ime').style.display = "none";
	k++;
}
if(!prezime.value.match(regPrezime)){
	prezime.style.border = "1px solid red";
	document.getElementById('prezime').style.display = "block";
}
else
{
	prezime.style.border = "none";
	document.getElementById('prezime').style.display = "none";
	k++;
}
if(!email.value.match(regEmail)){
	email.style.border = "1px solid red";
	document.getElementById('email').style.display = "block";
}
else
{
	email.style.border = "none";
	document.getElementById('email').style.display = "none";
	k++;
}
if(!lozinka.value.match(regLozinka)){
	lozinka.style.border = "1px solid red";
	document.getElementById('lozinka').style.display = "block";
}
else
{
	lozinka.style.border = "none";
	document.getElementById('lozinka').style.display = "none";
	k++;
}
if(!KIme.value.match(regKIme)){
	KIme.style.border = "1px solid red";
	document.getElementById('kime').style.display = "block";
}
else
{
	KIme.style.border = "none";
	document.getElementById('kime').style.display = "none";
	k++;
}
if(lozinka.value!=lozinka1.value){
	lozinka1.style.border = "1px solid red";
	document.getElementById('lozinka1').style.display = "block";
}
else
{
	lozinka1.style.border = "none";
	document.getElementById('lozinka1').style.display = "none";
	k++;
}
if(k>5){
	
		form2.submit();
		
}
}
/* Prijavljivanje */
function provera4(){
var regKIme = /^[A-z]{3,}([A-z]|[0-9])*$/;
var regLozinka = /^[A-z]{1}([A-z]|[0-9])*$/;

var lozinka2 = document.getElementById('tbLozinka2');
var KIme2 = document.getElementById('tbKorisnickoIme2');
var k = 0;

if(!lozinka2.value.match(regLozinka)){
	lozinka2.style.border = "1px solid red";
	document.getElementById('lozinka2').style.display = "block";
}
else
{
	lozinka2.style.border = "none";
	document.getElementById('lozinka2').style.display = "none";
	k++;
}
if(!KIme2.value.match(regKIme)){
	KIme2.style.border = "1px solid red";
	document.getElementById('kime3').style.display = "block";
}
else
{
	KIme2.style.border = "none";
	document.getElementById('kime3').style.display = "none";
	k++;
}
if(k>1){
	

		
		form3.submit();
}
}
function provera5(){
var k=0;
var izvodjac = document.getElementById('izvodjac');
var naslov = document.getElementById('naslov');
var tekst2 = document.getElementById('tekst2');
var zanr = document.getElementById('zanr').selectedIndex;

if(izvodjac.value=="")
{
	izvodjac.style.border = "1px solid red";
	document.getElementById('izvodjac1').style.display = "block";
}
else
{
	izvodjac.style.border = "none";
	document.getElementById('izvodjac1').style.display = "none";
	k++;
}
if(naslov.value=="")
{
	naslov.style.border = "1px solid red";
	document.getElementById('naslov1').style.display = "block";
}
else
{
	naslov.style.border = "none";
	document.getElementById('naslov1').style.display = "none";
	k++;
}
if(tekst2.value.length==0)
{
	tekst2.style.border = "1px solid red";
	document.getElementById('tekst1').style.display = "block";
}
else
{
	tekst2.style.border = "none";
	document.getElementById('tekst1').style.display = "none";
	k++;
}
if(document.getElementsByTagName("option")[zanr].value=="0")
{
	//zanr.style.border = "1px solid red";
	document.getElementById('zanr1').style.display = "block";
}
else
{
	//zanr.style.border = "none";
	document.getElementById('zanr1').style.display = "none";
	k++;
}
if(k==4)
{
	form4.submit();
}

}