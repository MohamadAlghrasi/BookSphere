(function () {
  window.addEventListener("load", function () {
    window.setTimeout(() => {
      const preloader = document.querySelector(".preloader");
      if (preloader) {
        preloader.style.opacity = "0";
        preloader.style.display = "none";
      }
    }, 500);
  });

  window.addEventListener("scroll", function () {
    const backToTop = document.querySelector(".scroll-top");
    if (backToTop) {
      if (
        document.body.scrollTop > 50 ||
        document.documentElement.scrollTop > 50
      ) {
        backToTop.style.display = "flex";
      } else {
        backToTop.style.display = "none";
      }
    }
  });

  const navbarToggler = document.querySelector(".mobile-menu-btn");
  if (navbarToggler) {
    navbarToggler.addEventListener("click", function () {
      navbarToggler.classList.toggle("active");
    });
  }

// ------------------------- Registration ------------------------------

  const registrationForm = document.getElementById("registrationForm");
  if (registrationForm) {
    registrationForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const name = document.getElementById("name")?.value.trim();
      const email = document.getElementById("email")?.value.trim();
      const password = document.getElementById("password")?.value;
      const confirmPassword = document.getElementById("confirmPassword")?.value;
      const phone = document.getElementById("phone")?.value.trim();

      if (!name || !email || !password || !confirmPassword || !phone) {
        Swal.fire("All fields are required!");
        return;
      }

      if (!validateName(name)) return;
      if (!validateEmail(email)) return;
      if (!validatePhone(phone)) return;
      if (!validatePass(password)) return;

      if (password !== confirmPassword) {
        Swal.fire("Passwords don't match");
        return;
      }

      Swal.fire("You are successfully Registered").then(() => {
        registrationForm.submit();
      });
    });
  }

  function validateName(name) {
    let nameRegExp = /^[A-Za-z\s]+$/;
    if (!nameRegExp.test(name)) {
      Swal.fire("Invalid Name");
      return false;
    }
    return true;
  }

  function validatePhone(phone) {
    let phoneRegExp = /^\+962\d{9}$/;
    if (!phoneRegExp.test(phone)) {
      Swal.fire("Invalid Phone Format. Example: +9627XXXXXXXX");
      return false;
    }
    return true;
  }

  function validateEmail(email) {
    let emailRegExp = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegExp.test(email)) {
      Swal.fire("Invalid Email Address");
      return false;
    }
    return true;
  }

  function validatePass(pass) {
    let passRegExp = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;
    if (!passRegExp.test(pass)) {
      Swal.fire(
        "Password must be 8+ and include: uppercase, number, special char"
      );
      return false;
    }
    return true;
  }

//------------------------------ Login -----------------------------------

  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const loginEmail = document.getElementById("loginEmail")?.value.trim();
      const loginPassword = document.getElementById("loginPassword")?.value;

      if (!loginEmail || !loginPassword) {
        Swal.fire("All fields are required!");
      } else {
        loginForm.submit();
      }
    });
  }
})();
