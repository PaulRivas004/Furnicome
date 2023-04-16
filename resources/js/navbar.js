 function cambiarBg(){
   var navbar = document.getElementById('menus');
   var scrollvalue = window.scrollY;

   if (scrollvalue < 50){
       navbar.classList.remove('h')
   } else{
       navbar.classList.add('blanco')
   }
}

window.addEventListener('scroll', cambiarBg) 