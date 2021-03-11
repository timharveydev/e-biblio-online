// Toggles the dropdown menu for the account icon in the navbar

// Variables
const dropdownMenu = document.querySelector('.nav__dropdown');
const userIcon = document.querySelector('.userIcon');
let dropdownToggleState = false;


// Toggles menu with fade effect
function toggleDropdownMenu() {
  if (dropdownToggleState == false) {

    dropdownMenu.style.display = 'block';
    dropdownMenu.style.opacity = '1';

    userIcon.classList.toggle('active');

    dropdownToggleState = true;

  }
  else {

    dropdownMenu.style.opacity = '0';
    dropdownMenu.style.display = 'none';

    userIcon.classList.toggle('active');
    
    dropdownToggleState = false;

  }
}