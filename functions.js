var i = 1;
var j = 1;

var nb_q = 0;
var Tableau_rep = new Array(50);
for (var k = 0; k < Tableau_rep.length; k++) {
	Tableau_rep[k] = 0;
}


function ajouter_question_mult(num_q,element) {
	var formulaire = document.questionnaire;

	nb_q ++;

	//initule de la question
	var champ = document.createElement("input");
	champ.name = "titreq"+num_q;
	champ.type = "text";
	champ.required = "true";
	champ.className = "champ_q";
	champ.placeholder = "Question : ";

	var saut = document.createElement("br");

	//compteur de réponses
	var hide = document.createElement("input");
	hide.type = "hidden";
	hide.id = "q"+num_q+"nb_rep";
	hide.name = "q"+num_q+"nb_rep";
	hide.value = 0;

	//bouton ajout réponse
	var champ_reponse = document.createElement("input");
	champ_reponse.type="button";
	champ_reponse.className = "button_rep"
	champ_reponse.value="Ajouter réponse";
	champ_reponse.onclick= function onclick(event) {ajouter_reponse_mult(num_q,i,this);};

	//bouton supprimer
	var sup = document.createElement("input");
	sup.value = "";
	sup.className = "button_supp_q";
	sup.type = "button";
	// Ajout de l'événement onclick
	sup.onclick = function onclick(event)
	{suppression_question(this);};

	var bloc = document.createElement("div");
	bloc.id="question"+num_q;
	bloc.className = "div_question";
	//bloc.style.background = "grey";
	//bloc.style.margin = "5px 5px 5px 5px";
	//bloc.style.width = "80%";

	bloc.appendChild(sup);
	bloc.appendChild(champ);
	bloc.appendChild(hide);
	bloc.appendChild(saut);
	bloc.appendChild(champ_reponse);

	//2 saut pour arriver avant le champ ajout unique
	formulaire.insertBefore(bloc,element.previousSibling.previousSibling);

	j = j + 1;
}

function ajouter_question(num_q,element) {
	var formulaire = document.questionnaire;

	nb_q ++;

	//initule de la question
	var champ = document.createElement("input");
	champ.name = "titreq"+num_q;
	champ.type = "text";
	champ.required = "true";
	champ.className = "champ_q";
	champ.placeholder = "Question : ";

	var hide = document.createElement("input");
	hide.type = "hidden";
	hide.id = "q"+num_q+"nb_rep";
	hide.name = "q"+num_q+"nb_rep";
	hide.value = 0;

	var saut = document.createElement("br");

	//bouton ajout réponse
	var champ_reponse = document.createElement("input");
	champ_reponse.type="button";
	champ_reponse.className = "button_rep";
	champ_reponse.value="Ajouter réponse";
	champ_reponse.onclick= function onclick(event) {ajouter_reponse(num_q,i,this);};

	//bouton supprimer
	var sup = document.createElement("input");
	sup.value = "";
	sup.type = "button";
	sup.className = "button_supp_q";
	// Ajout de l'événement onclick
	sup.onclick = function onclick(event)
	{suppression_question(this);};

	var bloc = document.createElement("div");
	bloc.id="question"+num_q;
	bloc.className = "div_question";
	//bloc.style.background = "grey";
	//bloc.style.margin = "5px 5px 5px 5px";
	//bloc.style.width = "80%";

	bloc.appendChild(sup);
	bloc.appendChild(champ);
	bloc.appendChild(hide);
	bloc.appendChild(saut);
	bloc.appendChild(champ_reponse);

	formulaire.insertBefore(bloc,element);

	j = j + 1;
}

function ajouter_reponse(num_q,num_el,element) {

	Tableau_rep[num_q]++;

	var mon_id = "question"+num_q;

	var formulaire = document.getElementById(mon_id);

	var id2 = "q"+num_q+"nb_rep";
	var valeur = parseInt(document.getElementById(id2).value);
	document.getElementById(id2).value = valeur + 1;
	//Parseint(string val);


	// Crée un nouvel élément de type "input texte"
	var champ = document.createElement("input");
	champ.name = "rep"+num_q+","+num_el;
	champ.type = "text";
	champ.className = "champ_r";
	champ.required = "true";
	champ.placeholder = "Reponse : ";
	
	var champ_radio = document.createElement("input");
	champ_radio.name = "repq"+num_q;
	champ_radio.className = "champ_radio_r";
	champ_radio.type = "radio";
	champ_radio.value = "rep"+num_q+","+num_el;
	if (Tableau_rep[num_q] == 1) {
		champ_radio.checked = true;
	}


	var sup = document.createElement("input");
	sup.value = "";
	sup.type = "button";
	sup.className = "button_supp_r";
	// Ajout de l'événement onclick
	sup.onclick = function onclick(event)
	{
		Tableau_rep[num_q]--;
		suppression_reponse(num_q,this);
	};
	     
	// On crée un nouvel élément de type "p" et on insère le champ l'intérieur.
	var bloc = document.createElement("div");
	bloc.className = "div_reponse";
	bloc.appendChild(sup);
	bloc.appendChild(champ);
	bloc.appendChild(champ_radio);

	formulaire.insertBefore(bloc, element);

	i = i + 1;
}

function ajouter_reponse_mult(num_q,num_el,element) {

	Tableau_rep[num_q]++;

	var mon_id = "question"+num_q;

	var formulaire = document.getElementById(mon_id);

	var id2 = "q"+num_q+"nb_rep";
	var valeur = parseInt(document.getElementById(id2).value);
	document.getElementById(id2).value = valeur + 1;	

	// Crée un nouvel élément de type "input texte"
	var champ = document.createElement("input");
	champ.name = "rep"+num_q+","+num_el;
	champ.type = "text";
	champ.className = "champ_r";
	champ.required = "true";
	champ.placeholder = "Reponse : ";
	
	var champ_checkbox = document.createElement("input");
	champ_checkbox.name = "rep"+num_el+"q"+num_q;
	champ_checkbox.type = "checkbox";
	champ_checkbox.className = "champ_checkbox_r";
	champ_checkbox.value = "rep"+num_q+","+num_el;
	if (Tableau_rep[num_q] == 1) {
		champ_checkbox.checked = true;
	}




	var sup = document.createElement("input");
	sup.value = "";
	sup.type = "button";
	sup.className = "button_supp_r";
	// Ajout de l'événement onclick
	sup.onclick = function onclick(event)
	{
		Tableau_rep[num_q]--;
		suppression_reponse(num_q,this);
	};
	     
	// On crée un nouvel élément de type "p" et on insère le champ l'intérieur.
	var bloc = document.createElement("div");
	bloc.className = "div_reponse";
	bloc.appendChild(sup);
	bloc.appendChild(champ);
	bloc.appendChild(champ_checkbox);

	formulaire.insertBefore(bloc, element);

	i = i + 1;
}			

function suppression_reponse(num_q,element){
	//var formulaire = window.document.questionnaire;

	var id2 = "q"+num_q+"nb_rep";
	var valeur = parseInt(document.getElementById(id2).value);
	document.getElementById(id2).value = valeur - 1;

	var mon_id = "question"+num_q;

	var formulaire = document.getElementById(mon_id);

	formulaire.removeChild(element.parentNode);
}

function suppression_question(element) {
	var formulaire = window.document.questionnaire;

	nb_q --;

	formulaire.removeChild(element.parentNode);
}

function soumettre_form() {
	var nb_q_rep_ok = 0;

	for (var i = 0 ; i < Tableau_rep.length ; i++) { //on parcours tout le tableau
		if (Tableau_rep[i] > 1) { //si il y a au moins 2 réponses a la question
			nb_q_rep_ok ++;
		}
	}
 
	if (nb_q != 0 && nb_q == nb_q_rep_ok) { //si il y a au moins une question et que le nombre_question_ok == nb_question
		return true; //on soumet le formulaire
	}
	else {
		alert("Des champs sont encore à compléter");
		return false;
	}
}
