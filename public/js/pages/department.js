const departmentRules = {

    department_code: {
        required: true,
        alphaNumeric: true,
        messages: {
            required: "Field is required.",
            alphaNumeric: "AlphaNumerice allowed.",
        }
    },

    department_name: {
        required: true,
        alphabet: true,
        messages: {
            required: "Field is required.",
            alphabet: "Alphabets are allowed.",
        }
    }

};
$(function () {

    // Add Form
    $('#Addmodel form').on('submit', function (e) {

        let valid = InlineValidator.validate(this, departmentRules);

        if (!valid) {
            e.preventDefault();
            return false;
        }

    });
    // Edit Form
    $('#Editmodel form').on('submit', function (e) {

        let valid = InlineValidator.validate(this, departmentRules);

        if (!valid) {
            e.preventDefault();
            return false;
        }

    });

    // Remove error while typing
    $(document).on('keyup change', '.form-control', function () {
        $(this)
            .removeClass('is-invalid')
            .closest('.form-field')
            .find('.text-errors')
            .text('');
    });

});
