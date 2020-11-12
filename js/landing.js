// Select element function
const selectElement = function(element){
    return document.querySelector(element);
};

let menuToggler = selectElement('.menu-toggle');
let body = selectElement('body');

//The classList property returns the class name(s) of an element, as a DOMTokenList object.
menuToggler.addEventListener('click', function(){
    body.classList.toggle('open');         // toggle - if element exists in class then remove it, if it doesn't exist add it
});

// Scroll reveal
window.sr = ScrollReveal();

sr.reveal('.animate-left',{
    origin: 'left',
    duration: 1000, //in milliseconds
    distance: '25rem',
    delay: 300
});

sr.reveal('.animate-right',{
    origin: 'right',
    duration: 1000, //in milliseconds
    distance: '25rem',
    delay: 600
});

sr.reveal('.animate-top',{
    origin: 'top',
    duration: 1000, //in milliseconds
    distance: '25rem',
    delay: 600
});

sr.reveal('.animate-bottom',{
    origin: 'bottom',
    duration: 1000, //in milliseconds
    distance: '25rem',
    delay: 600
});
