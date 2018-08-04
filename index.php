<?php
ini_set('display_errors'        , 'On');
ini_set('display_startup_errors', 'On');
ini_set('error_reporting'       , 'E_ALL | E_STRICT');
ini_set('track_errors'          , 'On');
ini_set('display_errors'        , 1);
error_reporting(E_ALL);
?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

    
<script type="text/javascript">

function my_delay(message)
{


    console.log(message);
    message = jQuery.parseJSON(message);   
    switch (message.type) {
     case "fajr":
         var audio_fajr      = new Audio('http://localhost/TimeLaps/fajr-adhan.mp3');
         console.log("fajr delay");
         window.setTimeout(function()
                    {
                     audio_fajr.play();
                     ajax();   
                    }, message.delay);
        break;
     case "sunrise":
         var audio_sunrise   = new Audio('http://localhost/TimeLaps/sunrise.mp3');
         console.log("sunrise delay");
         window.setTimeout(function()
                    {
                     audio_sunrise.play();
                     ajax();   
                    }, message.delay);
        break;
     case "dhuhr":
         var audio_dhuhr     = new Audio('http://localhost/TimeLaps/dhuhr-adhan.mp3');
         console.log("dhuhr delay");
         window.setTimeout(function()
                    {
                     audio_dhuhr.play();
                     ajax();   
                    }, message.delay);     
         break;
     case "sunset":
         var audio_sunset    = new Audio('http://localhost/TimeLaps/sunset.mp3');
         console.log("sunset delay");
         window.setTimeout(function()
                    {
                     audio_sunset.play();
                     ajax();   
                    }, message.delay);        
         break;
     case "maghrib":
         var audio_maghrib   = new Audio('http://localhost/TimeLaps/maghrib-adhan.mp3');
         console.log("maghrib delay");
                 window.setTimeout(function()
                    {
                     audio_maghrib.play();
                     ajax();   
                    }, message.delay);
        break;
     case "delay":
        console.log("delay delay");
                 window.setTimeout(function()
                    {
                     ajax();   
                    }, message.delay);
        break;
     default:
     console.log("Sorry, we are out of " + expr + ".");
    }
//     var audio = new Audio('Careless.mp3');
//     var audio2 = new Audio('The_Hellespont.mp3');
//     // $.when().then();
//         audio.play();
// window.setTimeout(function(){
//                  audio.pause();
//                  // audio2.play();   
//                   }, message);      
}
function ajax() 
{
     $.ajax({
    type: 'POST',
    // make sure you respect the same origin policy with this url:
    // http://en.wikipedia.org/wiki/Same_origin_policy
    url: 'http://localhost/TimeLaps/myphp.php',
    data: { 
        'JavadKhof': 'Im'   
    },
    success: function(msg){
        my_delay(msg);
    }
    });
}
$(document).ready(ajax());

</script>



















<!-- <script type="text/javascript">
    
// handles the click event for link 1, sends the query
function getOutput() {
  getRequest(
      'myphp.php', // URL for the PHP file
       drawOutput,  // handle successful request
       drawError    // handle error
  );
  return false;
}  
// handles drawing an error message
function drawError() {
    var container = document.getElementById('output');
    container.innerHTML = 'Bummer: there was an error!';
}
// handles the response, adds the html
function drawOutput(responseText) {
    var container = document.getElementById('output');
    container.innerHTML = responseText;
}
// helper function for cross-browser request object
function getRequest(url, success, error) {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {
                return false;
            }
        }
    }
    if (!req) return false;
    if (typeof success != 'function') success = function () {};
    if (typeof error!= 'function') error = function () {};
    req.onreadystatechange = function(){
        if(req.readyState == 4) {
            return req.status === 200 ? 
                success(req.responseText) : error(req.status);
        }
    }
    req.open("GET", url, true);
    req.send("JavadKhod=i'm");
    return req;
}
var Out = getOutput();

</script>
 -->