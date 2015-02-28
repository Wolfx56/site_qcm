<!DOCTYPE html>

<html>

<body>

   <?php
      if (isset($_POST["soumettre"])) {
         var_dump($_POST);
      }
      else {
   ?>

<script type="text/Javascript" >

var i = 1;

   function suppression(element){
   var formulaire = window.document.formulaireDynamique;
        
   // Supprime le bouton d'ajout
   formulaire.removeChild(element.previousSibling);
   // Supprime le champ
   formulaire.removeChild(element.nextSibling);
   // Supprime le bouton de suppression
   formulaire.removeChild(element);
}


   function ajout(element){

      var formulaire = window.document.formulaireDynamique;
      // On clone le bouton d'ajout
      var ajout = element.cloneNode(true);
      // Crée un nouvel élément de type "input"
      var champ = document.createElement("input");
      // Les valeurs encodée dans le formulaire seront stockées dans un tableau
      champ.name = "champs[]";
      champ.type = "radio";
      champ.value = i;
        
      var sup = document.createElement("input");
      sup.value = "supprimer un champ";
      sup.type = "button";
      // Ajout de l'événement onclick
      sup.onclick = function onclick(event)
         {suppression(this);};
        
      // On crée un nouvel élément de type "p" et on insère le champ l'intérieur.
      var bloc = document.createElement("p");
      bloc.appendChild(champ);
      formulaire.insertBefore(ajout, element);
      formulaire.insertBefore(sup, element);
      formulaire.insertBefore(bloc, element);

      i = i + 1;
   }

</script>

<div id="page">
   <form name="formulaireDynamique" method="POST" action="">
      <input type="button" onclick="ajout(this);" value="ajouter un champ"/>
      <br /><br />
      <input type="submit" value="soumettre" name="soumettre"/>
   </form>

      <?php
         }
      ?>

</div>

</body>

</html>