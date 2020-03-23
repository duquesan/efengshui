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
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function(){
   
   $("#next-1").click(function(){
      $(function() {

         function errorPlacement(error, element) {
              var container = $('<div />');
              container.addClass('errorTip error');  // add a class to the wrapper
              error.insertBefore(element);
              error.wrap(container);
          }
      
         $.validator.addMethod("unique", function(value, element) {
            var parentForm = $(element).closest('form');
            var timeRepeated = 0;
            if (value != '') {
               $(parentForm.find(':text')).each(function () {
                  if ($(this).val() === value) {
                     timeRepeated++;
                  }
               });
            }
            return timeRepeated === 1 || timeRepeated === 0;
            
         }, "* Duplicate");
         
         $("#newsletter").validate({
            rules: {
               email: {
                  required: true,
                  email: true
               }
            },
            errorPlacement: errorPlacement,
            submitHandler: function(form) {
               // do other things for a valid form
               //$(form).submitForm();
               $(' :input', form).not(':button, :submit, :reset, :hidden').val("");
            }
         });
      });
      
      /************************************************
       * @codeDescription    Check for Human on forms *
       ************************************************/
      
      (function() {
         $('.realTest').css({
            'opacity': 0,
            'height': 0,
            'visibility': 'hidden',
            'position': 'absolute',
            'left': -9999,
            'z-index': -9999
         });
      })();
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
});


// $(document).ready(function(){
//    $("#next-1").click(function(e){
//       //Pour empêcher de rafraichir la page, mais autant retirer le # ?
//       e.preventDefault();
//       if($("#criteres_titre_diagnostic").val() == ''){
//          $("#titreError").html('* Vous devez entrer un titre de diagnostic');
//          return false;//Si pas valide ça retourne ce message et ne pas aller plus loin
//       }
//       else if($("#criteres_titre_diagnostic").val().length < 2){
//          $("#titreError").html('* Le titre de votre diagnostic doit comporter plus de 2 caractères');
//          return false;
//       }
//       else if(!isNaN($("#criteres_titre_diagnostic").val())){
//          $("#titreError").html('* Les chiffres ne sont pas acceptés.')
//          return false;
//       }
//       else if($("criteres_nb_m_carre").val() == ''){
//          $("#mCarreError").html('* Le nombre de mètre carré est requis');
//          return false;
//       }
//       else if(!$('input:checked').val()){
//          $("#lieuError").html('* Vous devez sélectionner un lieu');
//          return false;
//          //A voir pour préciser l'input
//       }
//       else if($("criteres_annee_constr").val() == ''){
//          $("#anneeError").html('* Vous devez entrer une année de construction');
//          return false;
//       }
//       else{
//          $("#second").show();
//          $("#first").hide();
//          $("#progressbar li").eq(0).removeClass("active").addClass("done");
//          $("#progressbar li").eq(1).addClass("active");     
//       } 
//    });
//    $("#next-2").click(function(){
//     $("#third").show();
//     $("#second").hide();    
//     $("#progressbar li").eq(1).removeClass("active").addClass("done");
//     $("#progressbar li").eq(2).addClass("active");
//    });
//    $("#prev-2").click(function(){
//     $("#second").hide();
//     $("#first").show();
//     $("#progressbar li").eq(1).removeClass("done").addClass("active");
//     $("#progressbar li").eq(0).addClass("active");
//    });
//    $("#prev-3").click(function(){
//     $("#second").show();
//     $("#third").hide();
//     $("#progressbar li").eq(2).removeClass("done").addClass("active");
//     $("#progressbar li").eq(1).addClass("active");
//    });
// });


