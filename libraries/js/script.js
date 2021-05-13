let profilBtn = document.querySelector(".profilBtnContent");
let menu = document.querySelector(".menu");
let closeBtn = document.querySelector(".close");

profilBtn.addEventListener("click", function(){
    menu.style.animation = "0.5s showMenu forwards";
});

closeBtn.addEventListener("click", function(){
    menu.style.animation = "0.5s hideMenu forwards";
});

function session(){
    window.location="index.php?disconnect";
}
setTimeout("session()",300000);