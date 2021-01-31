$( document ).ready(function() {
    new WOW().init();
});

let header = document.querySelector(".nav");
let listeBtn = document.querySelector(".listeBtn");
let checkBox = document.querySelector(".checkBox");
let lastScrollValue = 0;

document.addEventListener('scroll',() => {
    checkBox.checked = false;
        let top  = document.documentElement.scrollTop;
    if(top > 75) {
        header.classList.add("hidden");
    } 
    if(lastScrollValue > top) {
        header.classList.remove("hidden");
    }

    
    lastScrollValue = top;
});