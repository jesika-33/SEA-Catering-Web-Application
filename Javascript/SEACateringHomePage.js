function toggleMenu() {
      const menu = document.querySelector('.menu');
      menu.classList.toggle('mobile');
    }

    // JavaScript for Active Navigation Link
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll("nav .menu li a");

    window.addEventListener("scroll", () => {
      let current = "";

      sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (pageYOffset >= sectionTop - sectionHeight / 3) {
          current = section.getAttribute("id");
        }
      });

    //   navLinks.forEach((link) => {
    //     link.classList.remove("active");
    //     if (link.getAttribute("href").includes(current)) {
    //       link.classList.add("active");
    //     }
    //   });
    });
