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












































































































































































// $(document).ready(function(){
//    $("#next-1").click(function(){
//     $("#second").show();
//     $("#first").hide();
//     $("#progressBar").css("width","60%");
//     $("#progressbarText").html("Etape 2");

//    });
//    $("#next-2").click(function(){
//     $("#third").show();
//     $("#second").hide();
//     $("#progressBar").css("width","100%");
//     $("#progressbarText").html("Step - 3");
//    });
//    $("#prev-2").click(function(){
//     $("#second").hide();
//     $("#first").show();
//     $("#progressBar").css("width","20%");
//     $("#progressbarText").html("Step - 1");
//    });
//    $("#prev-3").click(function(){
//     $("#second").show();
//     $("#third").hide();
//     $("#progressBar").css("width","60%");
//     $("#progressbarText").html("Step - 2");
//    });
// });


var i = 1;
$('.progress .circle').removeClass().addClass('circle');
$('.progress .bar').removeClass().addClass('bar');
setInterval(function() {
  $('.progress .circle:nth-of-type(' + i + ')').addClass('active');
  //pour le cercle bleu

  $('.progress .circle:nth-of-type(' + i + ') .label').html('&#46;&#46;&#46;');
  
  $('.progress .circle:nth-of-type(' + (i-1) + ')').removeClass('active').addClass('done');
  //Pour le vert
  
  $('.progress .circle:nth-of-type(' + (i-1) + ') .label').html('&#10003;');
  //10003 correspond au V
  
//   $('.progress .bar:nth-of-type(' + (i-1) + ')').addClass('active');
  
//   $('.progress .bar:nth-of-type(' + (i-2) + ')').removeClass('active').addClass('done');
  
  i++;
  
  
}, 1000);


