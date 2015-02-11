<html>
	<!-- 
		A Faire :
			- Choix multiple : récupérer toutes les réponses
			- Récupérer les questions et les réponses et les stocker dans la database
	-->
	<head>
		<title>Test d'enregistrement questionnaire</title>
		<meta charset="utf-8"/>
	</head>

	<body>
		<script type="text/javascript">
			var reponses = new Array (0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //sup a 15 valeurs pour l'overflow
			var nb_questions = 1;			

			function create_champ_reponse(i,j,type) {
				
				if (reponses[j] < 10) { 
					var i2 = i + 1;
					 
					if (type == 1) {
						document.getElementById('reponses_'+j).innerHTML += '<span id="leschamps_'+j+i+'"> Rep'+i+' : <input type="text" name="rept'+j+i+'"/> <input type="radio" name="repq'+j+'" value="rep'+j+i+'"> <a href="javascript:delete_champ_reponse('+i+','+j+')">X</a> <br/> </span>';
						var rm = document.getElementById('ajout_reponse_'+j);
						rm.remove(document.getElementById("ajout_reponse_"+j));
					}

					else {
						document.getElementById('reponses_'+j).innerHTML += '<span id="leschamps_'+j+i+'"> Rep'+i+' : <input type="text" name="rept'+j+i+'"/> <input type="checkbox" name="repq'+j+i+'" value="rep'+j+i+'"> <a href="javascript:delete_champ_reponse('+i+','+j+')">X</a> <br/> </span>';
						var rm = document.getElementById('ajout_reponse_'+j);
						rm.remove(document.getElementById("ajout_reponse_"+j));						
					}
					reponses[j] ++;

					document.getElementById('reponses_'+j).innerHTML += (reponses[j] < 10 ) ? '<div id="ajout_reponse_'+j+'"> <span id="leschamps_'+j+i2+'"><a href="javascript:create_champ_reponse('+i2+','+j+','+type+')">Ajouter une réponse</a></span></div>' : '';

					//alert('key : '+j+'reponses : '+reponses[j]);
				}
			}
		
			function create_champ_question(j,type)  {
				if (nb_questions < 15) {
					var j2 = j + 1;

					if (type == 1) {
						document.getElementById('question_'+j).innerHTML = '<fieldset name="'+j+'"> <legend>Saisie de question</legend> <a href="javascript:delete_champ_question('+j+')">X</a>	Question : <input type="text" name="titreq'+j+'"/> <br/> <div id="reponses_'+j+'"> <span id="leschamps_'+j+'1"> Rep1 : <input type="text" name="rept'+j+'1"/> <input name="repq'+j+'" type="radio" value="rep'+j+'1"/> </span> <br/> <span id="leschamps_'+j+'2"> Rep2 : <input type="text" name="rept'+j+'2"/> <input name="repq'+j+'" type="radio" value="rep'+j+'2"/> </span> <br/> <div id="ajout_reponse_'+j+'"> <span id="leschamps_'+j+'3"><a href="javascript:create_champ_reponse(3,'+j+','+type+')">Ajouter une réponse</a></span> </div> </div> </fieldset> <br/>';
					}

					else {
						document.getElementById('question_'+j).innerHTML = '<fieldset name="'+j+'"> <legend>Saisie de question</legend> <a href="javascript:delete_champ_question('+j+')">X</a>	Question : <input type="text" name="titreq'+j+'"/> <br/> <div id="reponses_'+j+'"> <span id="leschamps_'+j+'1"> Rep1 : <input type="text" name="rept'+j+'1"/> <input name="repq'+j+'1" type="checkbox" value="rep'+j+'1"/> </span> <br/> <span id="leschamps_'+j+'2"> Rep2 : <input type="text" name="rept'+j+'2"/> <input name="repq'+j+'1" type="checkbox" value="rep'+j+'2"/> </span> <br/> <div id="ajout_reponse_'+j+'"> <span id="leschamps_'+j+'3"><a href="javascript:create_champ_reponse(3,'+j+','+type+')">Ajouter une réponse</a></span> </div> </div> </fieldset> <br/>';					
					}

					reponses[j] = 2 ;
					nb_questions++;

					document.getElementById('champs').innerHTML += (nb_questions < 15 ) ? '<div id="question_'+j2+'"><a href="javascript:create_champ_question('+j2+',1)">Ajouter une question à choix unique</a> <br/> <a href="javascript:create_champ_question('+j2+',2)">Ajouter une question à choix multiple</a> </div>' : '';
				}
			}

			function delete_champ_question(j){
				var j2 = j + 1;

				var parent = document.getElementById("question_"+j);
				parent.remove(document.getElementById("question_"+j));

				reponses[j] = 0;
				nb_questions--;

				document.getElementById('champs').innerHTML += (nb_questions == 14 ) ? '<div id="question_'+j2+'"><a href="javascript:create_champ_question('+j2+')">Ajouter une question</a></div>' : '';
			}

			function delete_champ_reponse(i,j){
				var i2 = i + 1;

				var parent = document.getElementById("leschamps_"+j+i);
				parent.remove(document.getElementById("leschamps_"+j+i));

				reponses[j] --;

				document.getElementById('reponses_'+j).innerHTML += (reponses[j] == 9 ) ? '<div id="ajout_reponse_'+j+'"> <span id="leschamps_'+j+i2+'"><a href="javascript:create_champ_reponse('+i2+','+j+')">Ajouter une réponse</a></span></div>' : '';
			}

		</script>

		<?php
			if (isset($_POST["rep"])) {
				echo "Var dump de Post : \n";	
				var_dump($_POST);
			}
			else {
		?>

		<div id ="page">
			<form method="POST" action:"">
				<div id="champs">
					Titre : <input type="text" name="titreqcm"/> <br/> 
					<br/>

					<div id="question_1"> 

						<fieldset name="1"><legend>Saisie de question</legend>
						
							Question : <input type="text" name="titreq1"/> <br/>
						
							<div id="reponses_1">
								<span id="leschamps_11"> Rep1 : <input type="text" name="rept11"/> <input name="repq1" type="radio" value="rep11"/> <br/> </span>
								<span id="leschamps_12"> Rep2 : <input type="text" name="rept12"/> <input name="repq1" type="radio" value="rep12"/> <br/> </span>

								<div id="ajout_reponse_1">
									<span id="leschamps_13"><a href="javascript:create_champ_reponse(3,1,1)">Ajouter une réponse</a></span>
								</div>

							</div>
					
						</fieldset> <br/>

					</div>

					<div id="question_2">
						<a href="javascript:create_champ_question(2,1)">Ajouter une question à choix unique</a> <br/>
						<a href="javascript:create_champ_question(2,2)">Ajouter une question à choix multiple</a>
					</div>	
				</div>

				<input type="submit" name="rep"/>
			
			</form>

		</div>
		<?php
			}
		?>
	</body>
</html>