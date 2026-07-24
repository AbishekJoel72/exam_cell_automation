const subjectRules = {

    department_code: {
        required: true,
        messages: {
            required: "Please select Department."
        }
    },

    course_code: {
        required: true,
        messages: {
            required: "Please select Course."
        }
    },

    semester: {
        required: true,
        number: true,
        min: 1,
        max: 2,
        messages: {
            required: "Field is required.",
            number: "Only Numbers are allowed.",
            min: "Minimum 1 digit required.",
            max: "Maximum 2 digits allowed."
        }
    },

    subject_code: {
        required: true,
        alphaNumeric: true,
        min: 2,
        max: 20,
        messages: {
            required: "Field is required.",
            alphaNumeric: "Only Letters and Numbers are allowed.",
            min: "Minimum 2 characters required.",
            max: "Maximum 20 characters allowed."
        }
    },

    subject_name: {
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
    },

    credits: {
        required: true,
        number: true,
        min: 1,
        max: 2,
        messages: {
            required: "Field is required.",
            number: "Only Numbers are allowed.",
            min: "Minimum 1 digit required.",
            max: "Maximum 2 digits allowed."
        }
    }

};

$(function () {

    // Submit Validation
    $('#Addmodel form, #Editmodel form').on('submit', function (e) {

        let isValid = true;

        $(this).find('.form-control, .form-select').each(function () {

            if (!InlineValidator.validateField($(this), subjectRules)) {
                isValid = false;
            }

        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }

    });

    // Live Validation
    $(document).on('keyup blur change', '.form-control, .form-select', function () {

        InlineValidator.validateField($(this), subjectRules);

    });

});
