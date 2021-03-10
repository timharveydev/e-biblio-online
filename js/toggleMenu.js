// Toggles the burger menu for mobile devices

// Variables
const navList = document.querySelector('.nav__list');
const burger = document.querySelector('.nav__burger');
let toggleState = false;


// Toggles menu with slide and fade effect
function toggleMenu() {
  if (toggleState == false) {

    navList.style.height = '35rem';
    navList.style.opacity = '1';

    burger.classList.toggle('active');

    toggleState = true;

  }
  else {

    navList.style.opacity = '0';
    navList.style.height = '0';

    burger.classList.toggle('active');
    
    toggleState = false;

  }
}


// Reset nav menu attributes when resizing screen
window.addEventListener('resize', () => {

  if (window.innerWidth > 1024) {

    navList.style.height = '3.8rem';
    navList.style.opacity = '1';

  }
  else {

    navList.style.height = '0';
    navList.style.opacity = '0';

  }

  burger.classList.remove('active');

  toggleState = false;

})