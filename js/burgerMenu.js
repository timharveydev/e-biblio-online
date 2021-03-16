// Toggles the burger menu on mobile devices

// Variables
const navList = document.querySelector('.nav__list');
const burger = document.querySelector('.nav__burger');
let burgerToggleState = false;


// Toggles menu with slide and fade effect
function toggleBurgerMenu() {
  if (burgerToggleState == false) {

    navList.style.height = '35rem';
    navList.style.opacity = '1';

    burger.classList.toggle('active');

    burgerToggleState = true;

  }
  else {

    navList.style.opacity = '0';
    navList.style.height = '0';

    burger.classList.toggle('active');
    
    burgerToggleState = false;

  }
}


// Reset nav menu attributes when resizing screen
window.addEventListener('resize', () => {

  if (window.innerWidth > 1024) {

    navList.style.height = '8rem';
    navList.style.opacity = '1';

  }
  else {

    navList.style.height = '0';
    navList.style.opacity = '0';

  }

  burger.classList.remove('active');

  burgerToggleState = false;

})