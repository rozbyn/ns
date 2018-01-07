/**
 * Created by Rozbyn on 30.04.2017.
 */

var act_que=0.0,prev_que=0.0,next_que=0;
var que_tree=[];
var t = document.getElementsByClassName("ques");
que_tree[-1.0]=1;
que_tree[0.0]=t[0];
que_tree[1.0]=t[1];
que_tree[1.1]=t[2];
que_tree[4.0]=t[3];
que_tree[4.1]=t[4];
que_tree[1.2]=t[5];


var a = document.getElementsByClassName("row_header");
document.getElementById("button_next").addEventListener("click", next, false);
document.getElementById("button_back").addEventListener("click", back, false);

for (var i=0; i<a.length; ++i) {
   a[i].addEventListener("click", function () {expand(this) }, false);
   a[i].nextElementSibling.style.display="block";
   a[i].nextElementSibling.style.height = "0";
}
function check() {
   var w=true;
   for (var i=0; i<a.length; ++i) {
      var g=a[i].nextElementSibling;
      var o=((g.offsetHeight=="0") || (g.style.height==""));
      if (o){
         w = w && true;
      } else {
         w = w && false;
      }
   }
   return w}
function expand(x) {
   var g = x.nextElementSibling;
   var icon=x.children[0];
   if (check()){
      if (icon.innerHTML == "") {
         open(g,icon);
      } else {
         close(g,icon);
   }}


}
function open(g,icon) {
   var u=size(g);
   setTimeout(function () {
      g.style.height = u +"px";
      setTimeout(function () {g.style.height="";},200);
   },20);
   icon.innerHTML="&#xE259";
   collapse();
}
function close(g, icon) {
   icon.innerHTML="&#xE258";
   var h=g.offsetHeight;
   g.style.height = h+"px";
   setTimeout(function () {g.style.height = "0";},20);
}
function collapse() {
   for (var i=0; i<a.length; ++i){
      var g = a[i].nextElementSibling;
      var icon=a[i].children[0];
      if (g.style.height==""){
         close(g, icon);
      }
   }


}
function size(g) {
   var t,u,h;
   t = g.style.height;
   u = g.style.display;
   g.style.height = "";
   g.style.display="block";
   h=g.offsetHeight;
   g.style.height = t;
   g.style.display = u;
   return h}
function next() {
   que_check();
   que_tree[act_que].style.display = "none";
   que_tree[next_que].style.display = "block";
   act_que=next_que;
   
}
function que_check() {
   switch(act_que){
      case 0.0:
         if (que_tree[0.0].children[1].children[0].children[0].checked){
            next_que=1.0;
            que_tree[-1.0]=1;
         } else if(que_tree[0.0].children[1].children[2].children[0].checked) {
            next_que=4.0;
            que_tree[-1.0]=2;
         } else{
            next_que=4.1;
            que_tree[-1.0]=3;
         }
         prev_que=0.0;
         break;
      case 1.0:
         next_que=1.1;
         prev_que=0.0;
         break;
      case 1.1:
         prev_que=1.0;
          if (que_tree[1.1].children[3].children[0].children[0].checked || que_tree[1.1].children[9].children[0].children[0].checked){
             next_que=4.0;
          } else{next_que=1.2;}
         break;
      case 4.0:
         if (prev_que==1.0){}




   }

}
function back() {
   que_check();
   que_tree[act_que].style.display = "none";
   que_tree[prev_que].style.display = "block";
   act_que=prev_que;
}