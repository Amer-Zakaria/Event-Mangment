/**
 * main.js
 * Client-side interactivity and form validation
 */

document.addEventListener("DOMContentLoaded", function () {
  // Contact Form Validation
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const alertContainer = document.getElementById("alert-container");
      alertContainer.innerHTML = ""; // Clear previous alerts

      if (!contactForm.checkValidity()) {
        event.stopPropagation();
        contactForm.classList.add("was-validated");
        return;
      }

      // If valid, show success message (Simulated)
      const alert = document.createElement("div");
      alert.className = "alert alert-success alert-dismissible fade show";
      alert.innerHTML = `
                <strong>Success!</strong> Your message has been sent. We will get back to you soon.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
      alertContainer.appendChild(alert);

      contactForm.reset();
      contactForm.classList.remove("was-validated");
    });
  }

  // Auto-dismiss alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert-dismissible");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });
});
