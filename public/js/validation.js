function initializeValidation() {
    const forms = document.querySelectorAll(".needs-validation");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            // Custom validation handle pannura form-na skip
            if ($(form).data('custom-validation')) {
                return;
            }
            e.preventDefault();
            form.classList.add("was-validated");

            if (!form.checkValidity()) {
                return;
            }

            form.submit();

        });

    });

}
