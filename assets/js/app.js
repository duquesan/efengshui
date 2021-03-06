import '../css/app.scss';
const $ = require('jquery');
require('bootstrap');
require('jquery-validation');

/********************************************* FORMULAIRE DIAGNOSTIQUE */

//Image bureau domicile

function addCheckAttribute() {
   let val = 0;
   //Il ne reconnait pas l'input criteres[lieu]
   $("input[name='criteres[lieu]']").click(function () {
      let prevVal = val;
      val = $("input [name='criteres[lieu]:checked").val();
      if (val !== prevVal) {
         $(this).attr('checked', true);
         $(`input[value=${prevVal}]`).attr('checked', false);
      }
   });
};
$(document).ready(function () {
   addCheckAttribute();
});


//Permet d'insérer le nom du fichier image dans l'input.

$(document).on('change', '.custom-file-input', function (event) {
   $(this).next('.custom-file-label').html(event.target.files[0].name).css("text-align", "start");
})

//DEROULE DU FORMULAIRE AVEC LA BARRE DE PROGRESSION

$(document).ready(function () {
   $("#next-1").click(function () {
      $("#msform").validate({
         rules: {
            "criteres[titre_diagnostic]": {
               "required": true,
               "minlength": 2,
               "maxlength": 20
            },
            "criteres[nb_m_carre]": {
               "required": true,
               "maxlength": 5,
               "digits": true
            },
            "criteres[lieu]": {

            },
            "criteres[annee_constr]": {
               "required": true,
               "digits": true,
               "maxlength": 4
            },
         }
      });
      if ($("#msform").valid() == true) {
         $("#second").show();
         $("#first").hide();
         $("#progressbar li").eq(1).removeClass("active").addClass("done");
         $("#progressbar li").eq(2).addClass("active");
      }
   })
})

$("#next-2").click(function () {
   $("#msform").validate({
      rules: {
         "criteres[plan_lieu]": {
            "required": true,
            "accept": true,
         },
         "criteres[photo_lieu]": {
            "required": true,
            "accept": "immage/jpg,jpeg,png",
         },
         "criteres[orientation]": {
            "required": true,
         }
      }
   });
   if ($("#msform").valid() == true) {
      $("#third").show();
      $("#second").hide();
      $("#progressbar li").eq(2).removeClass("active").addClass("done");
      $("#progressbar li").eq(3).addClass("active");
   }
})
$("#prev-2").click(function () {
   $("#second").hide();
   $("#first").show();
   $("#progressbar li").eq(2).removeClass("done").addClass("active");
   $("#progressbar li").eq(1).addClass("active");
   $("#progressbar li").eq(2).removeClass("active").addClass("white");
})

$("#prev-3").click(function () {
   $("#second").show();
   $("#third").hide();
   $("#progressbar li").eq(3).removeClass("done").addClass("active");
   $("#progressbar li").eq(2).addClass("active");
   $("#progressbar li").eq(3).removeClass("active").addClass("white");
})

$(document).ready(function () {
   $("#msform").submit(function (e) {
      $("#valid").show();
      $("#third").hide();
      $("#progressbar li").eq(3).removeClass("active").addClass("done");
      $("#progressbar li").eq(4).addClass("done");
      e.preventDefault();
      var url = e.currentTarget.action;
      var formData = new FormData(this);
      $.ajax({
         url: url,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false
      });
   });
});

$(document).ready(function () {
   $("#co").submit(function (e) {
      $("#first").show();
      $("#co").hide();
      $("#progressbar li").eq(0).removeClass("active").addClass("done");
      $("#progressbar li").eq(1).addClass("active");
      e.preventDefault();
      var url = e.currentTarget.action;
      $.ajax({
         url: url,
         type: 'post',
         data: $("#co").serialize(),
      });
      $(".dropdownicone").click(function () {
         $("#dropdowncritere").replaceWith($("#dropdownconnecte"));
      });
   });
});

//Les messages de vérifications de formulaire 
$.extend($.validator.messages, {
   required: "Ce champ est requis.",
   remote: "Veuillez corriger ce champ.",
   email: "Veuillez entrer une adresse e-mail valide.",
   url: "Veuillez entrer une URL valide.",
   date: "Veuillez entrer une date valide.",
   dateISO: "Veuillez entrer une date valide (ISO).",
   number: "Veuillez entrer un numéro valide.",
   digits: "Ce champ ne peut contenir que des chifres",
   creditcard: "Veuillez entrer une carte de crédit valide.",
   equalTo: "Les valeurs ne correspondent pas.",
   accept: "Veuillez entre une extension autorisée.",
   maxlength: $.validator.format("N'entrez pas plus de {0} caractères."),
   minlength: $.validator.format("Veuillez entrer au moins {0} caractères."),
   rangelength: $.validator.format("Veuillez entrer une valeur entre {0} et {1}."),
   range: $.validator.format("Veuillez entrer une valeur entre {0} et {1}."),
   max: $.validator.format("Veuillez entrer une valeur inférieure ou égale à {0}."),
   min: $.validator.format("Veuillez entrer une valeur supérieure ou égale à {0}."),
})



//------------------------------------------------------------------------------------------------------------------------------

/* GESTION: liste des clients - liste des diagnostics - liste des critères */

$("#clientsList").click(function () {
   //je récupère le bouton 'Liste des clients', lorsque je clique dessus j'exécute une fonction de callback
   Display_Load()
   //e.preventDefault(); //annule rechargement de la page (par défaut)
   ajax(); //j'exécute la fonction ajax()
});

$("#diagList").click(function () {
   Display_Load()
   //e.preventDefault(); 
   ajax2();
});

$("#demandesList").click(function () {
   Display_Load()
   //e.preventDefault(); 
   ajax3();
});

/* TRAITEMENT AJAX */

//Liste des clients

function ajax() {

   //$.getJSON : permet d'accéder au contenu du getJSON renvoyé par le controleur
   $.getJSON("/admin/gestion/listeUser", function (donnees) {

      Hide_Load();
      /* j'efface le contenu de ".entete" et ".corps" pour le vider avant d'ajouter mes donnees*/
      $(".entete").empty();
      $(".corps").empty();

      /* j'ajoute mes donnees à leur emplacement deja prévu dans le fichier de compte_admin.html.twig*/
      $(".entete").append("<th>Nom</th><th>Prénom</th><th>E-mail</th><th>Rôles</th><th colspan=2>Actions</th></tr>");
      /* "donnees" est un array qui contient les donnees envoyées par le controleur c'est à dire la liste des user (clients), je l'ajoute à son emplacement ".corps" et je lui ajoute les balises pour l'encrer dans un tableau "<table>" prévue à cet effet */
      donnees.forEach((i) => {
         $(".corps").append("<tr><td>" + i.nom + "</td><td>" + i.prenom + "</td><td>" + i.email + "</td><td>" + i.roles + "</td><td><a href='/admin/user/modifier/" + i.id + "'><i class='fa fa-pen'></i></a></td><td><a href='/user/supprimer/" + i.id + "'><i class='fa fa-trash'></i></a></td></tr>");
      });

   }, 'json');
}

//Liste des diagnostics

function ajax2() {

   $.getJSON("/admin/gestion/listeDiagnostic", function (donnees) {

      Hide_Load();
      $(".entete").empty();
      $(".corps").empty();

      $(".entete").append("<th>N°diagnostic</th><th>N°dossier</th><th>Date</th><th>Prix</th><th>Expertise</th><th>Envoyer</th></tr>");

      donnees.forEach((i) => {
         $(".corps").append("<tr><td>" + i.id + "</td><td>" + i.critere_id + "</td><td>" + i.date + "</td><td>" + i.prix + "</td><td><form enctype='multipart/form-data'><a href='../img/diagnostic.pdf' download='diactostic.pdf'><i class='fas fa-file-download'> Télécharger votre diagnostic</i></a></td><td><a href='#'><button><i class='fas fa-envelope'></i></button></a></td></tr>");
      });

   }, 'json');
}

//Liste des demandes

function ajax3() {

   $.getJSON("/admin/gestion/listeCritere", function (donnees) {

      Hide_Load();
      $(".entete").empty();
      $(".corps").empty();

      $(".entete").append("<th>N°dossier</th><th>Titre</th><th>M²</th><th>Lieu</th><th>Annee</th><th>Plan lieu</th><th>Photo</th><th>Orientation</th><th colspan=2>Actions</th></tr>");

      donnees.forEach((i) => {
         $(".corps").append("<tr><td>" + i.id + "</td><td>" + i.titre_diagnostic + "</td><td class='tailleCel'>" + i.nb_m_carre + "</td><td>" + i.lieu + "</td><td>" + i.annee_constr + "</td><td><img src='../img/" + i.plan_lieu + "' alt='plan' class='imgdiagnostic'></td><td><img src='../img/" + i.photo_lieu + "' alt='photo' class='imgdiagnostic'></td><td>" + i.orientation + "</td><td><form method='POST' action='/diagnostic/ajouter/" + i.id + "' enctype='multipart/form-data'><input type='file' name='pdfExpertise' accept='image/.pdf' class='inputdownload'/></form></td><td><a href='/admin/diagnostic/ajouter/" + i.id + "'><button class='btn btn-outline-success'>Valider</button></a></td></tr>");
      });

   }, 'json');

}

// CONFIRMATION AVANT VALIDATION

// $("#validerDiag").click( function(){ 
//   confirm("Vous etes sur le point de valider votre diagnostic");
// });

// CHARGEMENT

//Display Loading Image
function Display_Load() {
   $("#load").html("<div id='load' class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>");
   $('#resultat').hide();
}

//Hide Loading Image
function Hide_Load() {
   $("#load").html('');
   $('#resultat').show();
};
