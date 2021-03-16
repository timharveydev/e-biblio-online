// Toggle navbar background on page scroll

// Variables
const nav = document.querySelector('.nav');
const navTop = nav.offsetTop;


// Toggle bg on page scroll
window.onscroll = () => {
  
  if (window.pageYOffset >= navTop + 150) {

    nav.style.backgroundColor = 'rgba(238, 238, 238, 0.9)'; // 238,238,238 = $light-grey

  } else {

    nav.style.backgroundColor = 'transparent';
  }

}