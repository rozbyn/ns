/**
 * Created by Rozbyn on 05.10.2016.
 */

setInterval(function() {
   var p = document.getElementById("loreme");
   if (p.style.fontSize != "20px") {
      p.style.fontSize = "20px";
   } else {
      p.style.fontSize = "15px";
   }
}, 2000);


setInterval(function() {
   var heading = document.querySelector('h1');
   var hue = 'rgb(' + (Math.floor(Math.random() * 256)) +
       ',' +
       (Math.floor(Math.random() * 256)) +
       ',' +
       (Math.floor(Math.random() * 256)) + ')';

   heading.style.color = hue;
}, 1000);