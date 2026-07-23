function initializeValidation() {
    const forms = document.querySelectorAll(".needs-validation");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            form.classList.add("was-validated");
            if (!form.checkValidity()) {
                const first = form.querySelector(":invalid");
                if (first) {
                    first.focus();
                    first.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }
                return;
            }
            form.submit();
        });
    });
}



