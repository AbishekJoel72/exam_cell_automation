const departmentRules = {

    department_code: {
        required: true,
        alphaNumeric: true,
        min: 2,
        max: 20,
        messages: {
            required: "Field is required.",
            alphaNumeric: "Only Letters and numbers are allowed.",
            min: "Minimum 2 characters required.",
            max: "Maximum 20 characters allowed."
        }
    },

    department_name: {
        required: true,
        alphabet: true,
        min: 3,
        max: 100,
        messages: {
            required: "Field is required.",
            alphabet: "Only Alphabets are allowed.",
            min: "Minimum 3 characters required.",
            max: "Maximum 100 characters allowed."
        }
    }

};

$(function () {

    // Submit
    $('#Addmodel form, #Editmodel form').on('submit', function (e) {

        let isValid = true;

        $(this).find('.form-control').each(function () {

            if (!InlineValidator.validateField($(this), departmentRules)) {
                isValid = false;
            }

        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }

    });

    // Live Validation (Current input only)
    $(document).on('keyup blur', '.form-control', function () {

        InlineValidator.validateField($(this), departmentRules);

    });

});
