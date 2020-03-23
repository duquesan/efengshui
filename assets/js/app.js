/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';
const $ = require('jquery'); 
require('bootstrap');


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
//import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function(){
   $("#next-1").click(function(){
    $("#second").show();
    $("#first").hide();
    $("#progressbar li").eq(0).removeClass("active").addClass("done");
    $("#progressbar li").eq(1).addClass("active");

   });
   $("#next-2").click(function(){
    $("#third").show();
    $("#second").hide();    
    $("#progressbar li").eq(1).removeClass("active").addClass("done");
    $("#progressbar li").eq(2).addClass("active");
   });
   $("#prev-2").click(function(){
    $("#second").hide();
    $("#first").show();
    $("#progressbar li").eq(1).removeClass("done").addClass("active");
    $("#progressbar li").eq(0).addClass("active");
   });
   $("#prev-3").click(function(){
    $("#second").show();
    $("#third").hide();
    $("#progressbar li").eq(2).removeClass("done").addClass("active");
    $("#progressbar li").eq(1).addClass("active");
   });

   /* GESTION: liste des clients - liste des diagnostics - liste des critères */

   $("#clientsList").click( function(e){ 
   //je récupère le bouton 'Liste des clients', lorsque je clique dessus j'exécute une fonction de callback

      e.preventDefault(); //annule rechargement de la page (par défaut)
      ajax(); //j'exécute la fonction ajax()
   });

   $("#diagList").click( function(e){ 
   
      e.preventDefault(); 
      ajax2(); 
   });

   $("#demandesList").click( function(e){ 
   
      e.preventDefault(); 
      ajax3(); 
   });

   /* TRAITEMENT AJAX */

   //Liste des clients

   function ajax(){
      
      //$.getJSON : permet d'accéder au contenu du getJSON renvoyé par le controleur
      $.getJSON("/admin/gestion/listeUser",function( donnees ){

         /* j'efface le contenu de ".entete" et ".corps" pour le vider avant d'ajouter mes donnees*/
         $(".entete").empty();
         $(".corps").empty();

         /* j'ajoute mes donnees à leur emplacement deja prévu dans le fichier de compte_admin.html.twig*/
         $(".entete").append("<th>Nom</th><th>Prénom</th><th>E-mail</th><th>Rôles</th><th colspan=2>Actions</th></tr>");
            /* "donnees" est un array qui contient les donnees envoyées par le controleur c'est à dire la liste des user (clients), je l'ajoute à son emplacement ".corps" et je lui ajoute les balises pour l'encrer dans un tableau "<table>" prévue à cet effet */
         donnees.forEach((i) => {
            $(".corps").append("<tr><td>"+i.nom+"</td><td>"+i.prenom+"</td><td>"+ i.email +"</td><td>"+ i.roles +"</td><td><a href='/admin/user/modifier/"+i.id+"'><i class='fa fa-pen'></i></a></td><td><a href='/user/supprimer/"+i.id+"'><i class='fa fa-trash'></i></a></td></tr>");
         });

      }, 'json' );
   }

   //Liste des diagnostics

   function ajax2(){
      
      $.getJSON("/admin/gestion/listeDiagnostic",function( donnees ){

         $(".entete").empty();
         $(".corps").empty();

         $(".entete").append("<th>N°diagnostic</th><th>N°dossier</th><th>Date</th><th>Expertise</th></tr>");

         donnees.forEach((i) => {
            $(".corps").append("<tr><td>"+i.id+"</td><td>"+i.critere_id+"</td><td>"+ i.date +"</td><td>"+i.expertise+"</td><td>"+i.statut_expertise+"</td></tr>");
         });

      }, 'json' );
   }

   //Liste des demandes

   function ajax3(){
      
      $.getJSON("/admin/gestion/listeCritere",function( donnees ){

         $(".entete").empty();
         $(".corps").empty();
         $(".entete").append("<th>N°dossier</th><th>N°clients</th><th>Titre</th><th>Surface</th><th>Lieu</th><th>Annee construction</th><th>Plan lieu</th><th>Photo</th><th>Orientation</th><th colspan=2>Actions</th></tr>");

         donnees.forEach((i) => {
            $(".corps").append("<tr><td>"+i.id+"</td><td>"+i.user_id+"</td><td>"+i.titre_diagnostic+"</td><td>"+ i.nb_m_carre +"</td><td>"+ i.lieu +"</td><td>"+i.annee_constr+"</td><td><img src='../img/"+i.plan_lieu+"' alt='plan'></td><td><img src='../img/"+ i.photo_lieu +"' alt='photo'></td><td>"+i.orientation+"</td><td><button><a href='/diagnostic/ajouter/"+i.id+"'>Valider</a></button></td><td><a href='/user/supprimer/"+i.id+"'><i class='fa fa-trash'></i></a></td></tr>");
         });

      }, 'json' );
   }




});


