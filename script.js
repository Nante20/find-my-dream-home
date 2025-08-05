// @ts-nocheck
document.addEventListener("DOMContentLoaded", function () {
  // Validation formulaire d'inscription
  let registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      // @ts-ignore
      let email = document.getElementById("email").value.trim();
      let password = document.getElementById("password").value.trim();
      let confirmPassword = document
        .getElementById("confirm_password")
        .value.trim();
      let clientError = document.getElementById("clientError");
      clientError.textContent = "";

      let errors = [];

      if (!email || !password || !confirmPassword) {
        errors.push("Veuillez remplir tous les champs.");
      }
      if (!email.includes("@")) {
        errors.push("Veuillez saisir une adresse email valide.");
      }
      if (password.length < 6) {
        errors.push("Le mot de passe doit contenir au moins 6 caractères.");
      }
      if (password !== confirmPassword) {
        errors.push("Les mots de passe ne correspondent pas.");
      }

      if (errors.length > 0) {
        clientError.textContent = errors.join(" ");
        e.preventDefault();
      }
    });
  }

  // Validation formulaire de connexion
  let loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      let email = document.getElementById("email").value.trim();
      let password = document.getElementById("password").value.trim();
      let clientError = document.getElementById("clientError");
      clientError.textContent = "";

      let errors = [];

      if (!email || !password) {
        errors.push("Veuillez remplir tous les champs.");
      }
      if (!email.includes("@")) {
        errors.push("Veuillez saisir une adresse email valide.");
      }
      if (password.length < 6) {
        errors.push("Le mot de passe doit contenir au moins 6 caractères.");
      }

      if (errors.length > 0) {
        clientError.textContent = errors.join(" ");
        e.preventDefault();
      }
    });
  }
  // Validation formulaire ajout d'annonce
  let addForm = document.getElementById("addForm");
  if (addForm) {
    addForm.addEventListener("submit", function (e) {
      let image = document.getElementById("image").value.trim();
      let titre = document.getElementById("titre").value.trim();
      let prix = document.getElementById("prix").value.trim();
      let ville = document.getElementById("ville").value.trim();
      let description = document.getElementById("description").value.trim();
      let type = document.getElementById("type").value.trim();
      let clientError = document.getElementById("clientError");

      clientError.textContent = "";
      let errors = [];

      if (!image || !titre || !prix || !ville || !description || !type) {
        errors.push("Veuillez remplir tous les champs.");
      }

      if (errors.length > 0) {
        clientError.textContent = errors.join(" ");
        e.preventDefault();
      }
    });
  }
});
