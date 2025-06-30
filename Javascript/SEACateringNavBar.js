function toggleMenu() {
      const menu = document.querySelector('.menu');
      menu.classList.toggle('mobile');
    }

// // JavaScript for Active Navigation Link --> Use if some section in the nav bar are on the same page (not used for current version)
// const sections = document.querySelectorAll("section");
// const navLinks = document.querySelectorAll("nav .menu li a");

// window.addEventListener("scroll", () => {
//   let current = "";

//   sections.forEach((section) => {
//     const sectionTop = section.offsetTop;
//     const sectionHeight = section.clientHeight;

//     if (pageYOffset >= sectionTop - sectionHeight / 3) {
//     current = section.getAttribute("id");
//     }
//   });
// });
