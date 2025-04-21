let connecte = document.getElementById('connecter');
let inscrip = document.getElementById('inscription');
let gauche = document.querySelector('.form2');
let gauche_anaty = document.querySelector('.form1');
let droite = document.querySelector('.form3');
let droite_anaty = document.getElementById('n2');

let but1 = document.querySelector('.b1');
let but2 = document.querySelector('.b2');
inscrip.addEventListener('click', function() {
  gauche.style.width = 35+"%";
  gauche_anaty.style.opacity = 0;
  but1.style.opacity = 1;
  but1.style.transition = 1+"s ease-in-out";
  but1.style.position = "relative";
  but1.style.display = "block";
  droite.style.width = 65+"%";
  droite.style.marginleft = 35+"%";
  droite_anaty.style.opacity = 1;
  but2.style.opacity = 0;
  but2.style.transition = 0+"s ease-in-out";
  but2.style.position = "absolute";
})
connecte.addEventListener('click', function() {
  gauche.style.width = 65+"%";
  gauche_anaty.style.opacity = 1;
  but1.style.display = "none";
  droite.style.width = 35+"%";
  droite_anaty.style.opacity = 0;
  but2.style.transition = 1+"s ease-in-out";
  but2.style.opacity = 1;
  but2.style.position = "relative";
  droite.style.marginleft = 65+"%";
  console.log(droite.style.marginleft);

}); 

/*
<script type="text/javascript">
var vertical=-1;
setInterval(function() {
if (document.getElementById("container").scrollTop != vertical) {
  vertical=document.getElementById("container").scrollTop;
  console.log("div#container.scrollTop="+vertical);
}
}, 100);
</script>
*/