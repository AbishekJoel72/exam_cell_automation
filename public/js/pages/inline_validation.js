const InlineValidator = {
    validate(formSelector, rules) {
        let isValid = true;
        this.clear(formSelector);
        $.each(rules, function (field, rule) {

            let input = $(formSelector).find(`[name="${field}"]`);
            let value = $.trim(input.val());

            // Required
            if (rule.required && value === "") {
                InlineValidator.error(input, rule.messages.required);
                isValid = false;
                return;
            }

            // Minimum Length
            if (rule.min && value.length < rule.min) {
                InlineValidator.error(input, rule.messages.min);
                isValid = false;
                return;
            }

            // Maximum Length
            if (rule.max && value.length > rule.max) {
                InlineValidator.error(input, rule.messages.max);
                isValid = false;
                return;
            }


            // Email
            if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                InlineValidator.error(input, rule.messages.email);
                isValid = false;
                return;
            }

            // Mobile Number
            if (rule.phone && !/^[6-9]\d{9}$/.test(value)) {
                InlineValidator.error(input, rule.messages.phone);
                isValid = false;
                return;
            }

            // Number Only
            if (rule.number && !/^\d+$/.test(value)) {
                InlineValidator.error(input, rule.messages.number);
                isValid = false;
                return;
            }

            // Decimal
            if (rule.decimal && !/^\d+(\.\d{1,2})?$/.test(value)) {
                InlineValidator.error(input, rule.messages.decimal);
                isValid = false;
                return;
            }


            // Alphabets Only
            if (rule.alphabet && !/^[A-Za-z ]+$/.test(value)) {
                InlineValidator.error(input, rule.messages.alphabet);
                isValid = false;
                return;
            }

            // Alpha Numeric
            if (rule.alphaNumeric && !/^[A-Za-z0-9 ]+$/.test(value)) {
                InlineValidator.error(input, rule.messages.alphaNumeric);
                isValid = false;
                return;
            }


            // Username
            if (rule.username && !/^[A-Za-z][A-Za-z0-9_]{3,20}$/.test(value)) {
                InlineValidator.error(input, rule.messages.username);
                isValid = false;
                return;
            }

            // Password
            if (rule.password && !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?#&]).{8,}$/.test(value)) {
                InlineValidator.error(input, rule.messages.password);
                isValid = false;
                return;
            }




        });

        return isValid;

    },

    error(input, message) {
        input.addClass('is-invalid');
        input.closest('.form-field')
            .find('.text-errors')
            .text(message);
    },

    clear(formSelector) {
        $(formSelector)
            .find('.form-control')
            .removeClass('is-invalid');
        $(formSelector)
            .find('.text-errors')
            .text('');
    }

};
