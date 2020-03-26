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

   $('#tabUser').show();
   $('#tabDiagnostic').hide();
   $('#tabCritere').hide();

   $("#clientsList").click( function(){

      $('#tabUser').show();
      $('#tabDiagnostic').hide();
      $('#tabCritere').hide();
  
   });

   $("#diagList").click( function(){
      
      $('#tabUser').hide();
      $('#tabDiagnostic').show();
      $('#tabCritere').hide(); 
     
   });

   $("#demandesList").click( function(){
      
      $('#tabUser').hide();
      $('#tabDiagnostic').hide();
      $('#tabCritere').show(); 
      
   });

  
   // CONFIRMATION AVANT VALIDATION

   $(".valider").click( function(){ 
     
      confirm(" Etes vous sure de vouloir valider votre expertise? ");
     

   });


