var sumaECTS = Number("0");//globalna varijabla sa sumom ECTS bodova
var ispis;//globalna varijabla sa popisom predmeta

//zbrajanje ECTS bodova i kreiranje popisa odabranih kolegija
function zbroj(br){
	
	if(ispis==undefined){
		ispis="";
	}
	
	if (br.checked == true) {
		//ako smo označili checkbox povećaj vrijednost
		sumaECTS += Number(br.value);
		ispis+="- "+br.name+" "+br.value+" ECTS \n";
		
	} else if (br.checked == false) {
		//ako smo odznačili checkbox smanji vrijednost
		sumaECTS -= Number(br.value);
		ispis = ispis.replace("- "+br.name+" "+br.value+" ECTS \n", "");
		
	}
	document.getElementById("zbrojEcts").value = sumaECTS;
	
}

function resetSum(){
	location.href = "erasmus.php";
}

function ponistiSve(){
	ispis="";
	sumaECTS = Number("0");
	document.getElementById("zbrojEcts").value = sumaECTS;
	document.getElementById("preuzimanja").style.display = "none";	
	document.getElementById("gumb").style.display = "block";
	document.getElementById("thank").innerHTML="";
}

function zadaniOdabirSemestra(){
	document.getElementById("IDsemestar").getElementsByTagName('option')[0].selected='selected';
	document.getElementById("txtSemestar").innerHTML = "<b>Courses will be listed here...</b>";
}

//provjeravanje postoji li usmjerenje za odabrani studij
function usmjerenje(studij) {
	
	document.getElementById("porukaStudij").style.display = "block";
	var test = studij.options[studij.selectedIndex].getAttribute('data');
	
    if (studij.value == "") {
        document.getElementById("porukaStudij").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("porukaStudij").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","studij.php?q="+studij.value,true);
        xmlhttp.send();
    }
	if(test==""){
		document.getElementById("porukaStudij").style.display = "none";
	}	
	ponistiSve();
	zadaniOdabirSemestra();
}

//padajuci izbornik sa usmjerenjima, ukoliko dode do promjene ponistavaju se odabrane stavke
function odabirUsmjerenja(usmjerenje){
	ponistiSve();
	zadaniOdabirSemestra();
}

//padajuci sa odabirom semestra, nakon odabira salje sve podatke bazi i vraca popis kolegija
function semestar(dobaSemestra) {
	
	var idStudija = document.getElementById("studij_id").value;
	var usmjerenje_id = document.getElementById("usmjerenje_id").value;
	
    if (dobaSemestra == "" ) {
        document.getElementById("txtSemestar").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtSemestar").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","semestar.php?q="+dobaSemestra+"&studij="+idStudija+"&usmjerenje="+usmjerenje_id,true);
        xmlhttp.send();
    }
	ponistiSve();
	//ukoliko se bira drugi semestar tokom izracuna neka se ponisti zbroj ects bodova
}

//dugme za preuzimanje koje prikazuje oblike preuzimanja, onesposobljuje dodatni odabir kolegija
function vrstePreuzimanja(){
	// This will disable all the children of the div
	var nodes = document.getElementById("blokiraj").getElementsByTagName('*');
		for(var i = 0; i < nodes.length; i++){
			nodes[i].disabled = true;
		}
	
	document.getElementById("preuzimanja").style.display = "block";	
	document.getElementById("gumb").style.display = "none";	

}


///kreiranje txt dokumenta
function downloadTxt(){
	var brStudija=document.getElementById("studij_id").value;
	var studij = document.getElementById("studij_id").options.item(brStudija).text;
	
	var brSemestar=document.getElementById("IDsemestar").value;
	var sem = document.getElementById("IDsemestar").options.item(brSemestar).text;
	
	var lokalni_ispis = ispis.replace(/ \n/g, "\r\n");//ovdje zamjenjujem  \n sa \r\n tako da se u txt doc lijepo formatira, zamjenjuje se\n /g znaci globalno sve
	
		var meniUsmjerenje=document.getElementById("usmjerenje_id");
		for (var i=1; i<meniUsmjerenje.options.length; i++){
			if (meniUsmjerenje.options[i].selected==true){
				var nazivUsmjerenja = document.getElementById("usmjerenje_id").options.item(i).text;
				break
			}
		}
	if(nazivUsmjerenja==""||nazivUsmjerenja==undefined){
		var blob= new Blob([studij+"\r\n"+sem+"\r\n"+lokalni_ispis+"\r\nECTS sum is "+sumaECTS],{type:"text/plain;charset=utf-8"});
	}else{
		var blob= new Blob([studij+"\r\n"+nazivUsmjerenja+"\r\n"+sem+"\r\n"+lokalni_ispis+"\r\nECTS sum is "+sumaECTS],{type:"text/plain;charset=utf-8"});
	}
	saveAs(blob,"erasmus.txt");
	
	document.getElementById("thank").innerHTML = "Thank you for downloading!";
}

//sluzi za prikazivanje forme za unos mail adrese koja je skrivena
function mail(){
	document.getElementById("mailform").style.display = "block";
}

//slanje mail-a sa sadrzajem
function sendMail(){
	
	var brStudija=document.getElementById("studij_id").value;
	var studij = document.getElementById("studij_id").options.item(brStudija).text;
	
	var brSemestar=document.getElementById("IDsemestar").value;
	var sem = document.getElementById("IDsemestar").options.item(brSemestar).text;

	var nazivUsmjerenja="";
	var meniUsmjerenje=document.getElementById("usmjerenje_id");
		for (var i=1; i<meniUsmjerenje.options.length; i++){
			if (meniUsmjerenje.options[i].selected==true){
				nazivUsmjerenja = document.getElementById("usmjerenje_id").options.item(i).text;
				break
			}
		}
		
	var lokalni_ispis = ispis.replace(/ \n/g, "<br/>");//ovdje zamjenjujem  \n sa <br/> tako da se u mailu lijepo formatira
	
	var adresa=document.getElementById("mailadresa").value;
	
	if (adresa == "" ) {
        document.getElementById("porukamail").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("porukamail").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","email.php?adresa="+adresa+"&studij="+studij+"&usmjerenje="+nazivUsmjerenja+"&semestar="+sem+"&popis="+lokalni_ispis+"&suma="+sumaECTS,true);
        xmlhttp.send();
    }

	document.getElementById("mailform").style.display = "none";
	document.getElementById("thank").innerHTML = "An email was sent to "+adresa;
	document.getElementById("mailadresa").value="";
}

//generiranje pdf dokumenta sa sadrzajem
function downloadPDF() {
	
	var brStudija=document.getElementById("studij_id").value;
	var studij = document.getElementById("studij_id").options.item(brStudija).text;
	
	var brSemestar=document.getElementById("IDsemestar").value;
	var sem = document.getElementById("IDsemestar").options.item(brSemestar).text;

	var nazivUsmjerenja="";
	var meniUsmjerenje=document.getElementById("usmjerenje_id");
		for (var i=1; i<meniUsmjerenje.options.length; i++){
			if (meniUsmjerenje.options[i].selected==true){
				nazivUsmjerenja = document.getElementById("usmjerenje_id").options.item(i).text;
				break
			}
		}
		
	var doc = new jsPDF();
	doc.text(20, 20, studij);
	
	if(!(nazivUsmjerenja==""||nazivUsmjerenja==undefined)){
		doc.text(20, 30, nazivUsmjerenja);
		doc.text(20, 40, sem+"\n"+ispis+"\nECTS sum is "+sumaECTS);
	}else{
		doc.text(20, 30, sem+"\n"+ispis+"\nECTS sum is "+sumaECTS);
	}
	// Save the PDF
	doc.save('erasmus.pdf');
	
	document.getElementById("thank").innerHTML = "Thank you for downloading!";
}
