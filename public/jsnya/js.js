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
        passwordField.type = "password";
        toggleIcon.src = "img/eye-closed.png";
    }
}

// document.getElementById('rekapSelector').addEventListener('change', function () {
//     const dynamicDropdown = document.getElementById('dynamicDropdown');
//     const dynamicSelector = document.getElementById('dynamicSelector');
//     const dynamicLabel = document.getElementById('dynamicLabel');

//     // Clear existing options
//     dynamicSelector.innerHTML = '';

//     if (this.value === 'perBulan') {
//       dynamicLabel.textContent = 'Pilih Bulan';
//       const months = [
//         'January', 'February', 'March', 'April', 'May', 'June',
//         'July', 'August', 'September', 'October', 'November', 'December'
//       ];
//       months.forEach((month, index) => {
//         const option = document.createElement('option');
//         option.value = index + 1;
//         option.textContent = month;
//         dynamicSelector.appendChild(option);
//       });
//       dynamicDropdown.style.display = 'block';
//     } else if (this.value === 'perSemester') {
//       dynamicLabel.textContent = 'Pilih Semester';
//       const semesters = ['Semester 1', 'Semester 2'];
//       semesters.forEach((semester, index) => {
//         const option = document.createElement('option');
//         option.value = index + 1;
//         option.textContent = semester;
//         dynamicSelector.appendChild(option);
//       });
//       dynamicDropdown.style.display = 'block';
//     } else {
//       dynamicDropdown.style.display = 'none';
//     }
// });