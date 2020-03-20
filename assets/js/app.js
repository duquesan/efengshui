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


