document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".input-container input");

  // Tangani event focus dan blur
  inputs.forEach(input => {
      input.addEventListener("focus", () => {
          input.classList.add("focused");
      });

      input.addEventListener("blur", () => {
          if (input.value === "") {
              input.classList.remove("focused");
          }
      });

      // Tangani autofocus pada awal
      if (input.hasAttribute("autofocus") && input.value === "") {
          input.classList.add("focused");
      }
  });
});

function togglePassword() {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");  // Tanpa titik di sini!

    if (passwordField.type === "password") {
        passwordField.type = "text";  // Ubah tipe input menjadi teks (lihat password)
        toggleIcon.src = "img/eye-open.png";  // Ubah ikon menjadi mata terbuka
    } else {
        passwordField.type = "password";  // Ubah tipe input menjadi password (sembunyikan)
        toggleIcon.src = "img/eye-closed.png";  // Ubah ikon menjadi mata tertutup
    }
}




  