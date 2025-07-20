document.addEventListener("DOMContentLoaded", () => {
  loadComponent("./components/navbar.html", "#nav__component")
    .then(() => {
      const waitForButton = (id, callback) => {
        const checkExist = setInterval(() => {
          const btn = document.getElementById(id);
          if (btn) {
            clearInterval(checkExist);
            callback(btn);
          }
        }, 100); // Check every 100ms until button exists
      };

      waitForButton("login__btn", (loginBtn) => {
        loginBtn.addEventListener("click", () => {
          // Load login component and replace #root
          loadComponent("./pages/login.html", "#root", false);
        });
      });

      waitForButton("signup__btn", (registerBtn) => {
        registerBtn.addEventListener("click", () => {
          // Load register component and replace #root
          loadComponent("./pages/signup.html", "#root", false);
        });
      });
    })
    .then(() => loadComponent("./components/header.html", "#root", true))  
    .then(() => loadComponent("./components/about.html", "#root", true)) 
    .then(() => loadComponent("./components/clubs.html", "#root", true))
    .then(() => loadComponent("./components/events.html", "#root", true))
    .then(() => loadComponent("./components/contacts.html", "#root", true))
    .then(() => loadComponent("./components/footer.html", "#root", true))
    .catch((err) => console.error("Error loading components:", err));
});

/**
 * Loads an HTML component into a target element.
 * @param {string} filePath - Path to the HTML file.
 * @param {string} targetSelector - CSS selector of the target element.
 * @param {boolean} append - Whether to append the content (true) or replace it (false or undefined).
 * @returns {Promise<void>}
 */
function loadComponent(filePath, targetSelector, append = false) {
  return fetch(filePath)
    .then((response) => {
      if (!response.ok) throw new Error(response.statusText);
      return response.text();
    })
    .then((data) => {
      const target = document.querySelector(targetSelector);
      if (!target) throw new Error(`Target "${targetSelector}" not found.`);
      if (append) {
        target.insertAdjacentHTML("beforeend", data);
      } else {
        target.innerHTML = data;
      }
    });
}
