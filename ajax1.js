var httpObj=null;
function kreiranje(){
  if (window.ActiveXObject)

    return new ActiveXObject("Microsoft.XMLHTTP");
else if (window.XMLHttpRequest)
    return new XMLHttpRequest();
else{
     alert("Vas browser ne podrzava AJAX.");
     return null;
}
}

function proveraKorIme(obj){
    httpObj=kreiranje();
    if(httpObj!=null){
        var url="korIme.php?korIme="+obj.value;
        httpObj.onreadystatechange=povracaj;
//        url="postanskibroj.php";
//        data="gid="+obj.value;
//        httpObj.open("POST",url,true);
//        httpObj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//        httpObj.send(data);
        httpObj.open("POST",url,true);
        httpObj.send(null);
    }
}
function povracaj(){
    
    if(httpObj.readyState==4 || httpObj.readyState==200){
        var KIme = document.getElementById('tbKorisnickoIme');
        var povracaj=httpObj.responseText;

        if(povracaj!="")
		{
			KIme.style.border = "1px solid red";
			document.getElementById('kime').style.display = "block";
			document.getElementById('kime2').innerHTML="Korisnicko ime je vec zauzeto.";
		}
		else
		{
			KIme.style.border = "none";
			document.getElementById('kime').style.display = "none";
			document.getElementById('kime2').innerHTML="Primer: Marko123";
		}
    }
}
function proveraEmail(obj){
    httpObj=kreiranje();
    if(httpObj!=null){
        var url="email.php?email="+obj.value;
        httpObj.onreadystatechange=povracaj1;
//        url="postanskibroj.php";
//        data="gid="+obj.value;
//        httpObj.open("POST",url,true);
//        httpObj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//        httpObj.send(data);
        httpObj.open("POST",url,true);
        httpObj.send(null);
    }
}
function povracaj1(){
    
    if(httpObj.readyState==4 || httpObj.readyState==200){
        var KEmail = document.getElementById('tbEmail');
        var povracaj1=httpObj.responseText;

        if(povracaj1!="")
		{
			KEmail.style.border = "1px solid red";
			document.getElementById('email').style.display = "block";
			document.getElementById('email2').innerHTML="Ovaj mail je zauzet, molimo izaberite drugi..";
		}
		else
		{
			KEmail.style.border = "none";
			document.getElementById('email').style.display = "none";
			document.getElementById('email2').innerHTML="Primer: Marko123";
		}
    }
}