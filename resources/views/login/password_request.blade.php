<!DOCTYPE html>
<html lang="en">
@include('layout.include.head')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    .input-group-custom {
        position: relative;
    }

    .input-icon-end {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        pointer-events: none;
        font-size: 1.1rem;
        color: #6c757d;
    }

    .input-group-custom .form-control {
        padding-right: 45px;
    }
</style>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row align-items-stretch bg-white border rounded shadow w-100 overflow-hidden login-card-row">

            <!-- Left side Image -->
            <div class="col-md-6 p-0 d-none d-md-block position-relative">
                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80"
                     alt="Forgot Password Illustration"
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            </div>

            <!-- Right side Form -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="forgot-form">
                    <h2 class="text-center mb-3 fw-bold">Forgot Password</h2>
                    <p class="text-muted text-center small mb-4">
                        Choose how you want to receive your OTP to reset your password.
                    </p>

                    <!-- Form target is updated to handle password reset submission -->
                    <form id="otpForm" method="POST" action="{{ route('password_request') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- 1. Selection for Email or Phone -->
                        <div class="mb-4">
                            <label class="form-label d-block text-muted small fw-bold mb-2">Send OTP via:</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" id="methodEmail" value="email" checked>
                                    <label class="form-check-label" for="methodEmail">Email</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" id="methodPhone" value="phone">
                                    <label class="form-check-label" for="methodPhone">Phone Number</label>
                                </div>
                            </div>
                        </div>

                        <!-- 2a. Email Input Field -->
                        <div class="input-group-custom form-floating mb-4" id="emailInputContainer">
                            <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com">
                            <label for="email">Email Address</label>
                            <i class="bi bi-envelope-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>

                        <!-- 2b. Phone Input Field (Hidden by default) -->
                        <div class="input-group-custom form-floating mb-4 d-none" id="phoneInputContainer">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="9876543210">
                            <label for="phone">Phone Number</label>
                            <i class="bi bi-telephone-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>

                        <!-- 3. OTP Code Input Field (Changed from 6 to 4 Digits) -->
                        <div class="input-group-custom form-floating mb-4 d-none" id="otpInputContainer">
                            <input type="text" class="form-control" id="otp_code" name="otp_code" placeholder="1234" maxlength="4">
                            <label for="otp_code">Enter 4-Digit OTP</label>
                            <i class="bi bi-shield-lock-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>


                        <button type="button" id="actionBtn" class="btn btn-custom-primary w-100 mb-3">Send OTP</button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="back-link text-decoration-none" style="font-size: 0.9rem;">
                                Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @include('layout.include.script')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodEmail = document.getElementById('methodEmail');
            const methodPhone = document.getElementById('methodPhone');
            const emailContainer = document.getElementById('emailInputContainer');
            const phoneContainer = document.getElementById('phoneInputContainer');
            const otpContainer = document.getElementById('otpInputContainer');
            const actionBtn = document.getElementById('actionBtn');
            const otpForm = document.getElementById('otpForm');

            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const otpInput = document.getElementById('otp_code');

            let otpSent = false;

            function triggerModal(message, isSuccess = false) {
                const modalEl = document.getElementById('sessionModal');
                if (modalEl) {
                    const modalContent = modalEl.querySelector('.modal-content');

                    modalContent.classList.remove('border-success', 'border-danger');

                    document.getElementById("modalMessage").innerText = message;

                    if (isSuccess) {
                        modalContent.classList.add('border-success');
                    } else {
                        modalContent.classList.add('border-danger');
                    }

                    var myModal = new bootstrap.Modal(modalEl);
                    myModal.show();
                }
            }

            methodEmail.addEventListener('change', function() {
                emailContainer.classList.remove('d-none');
                emailInput.setAttribute('required', 'required');

                phoneContainer.classList.add('d-none');
                phoneInput.removeAttribute('required');
                phoneInput.value = '';
            });

            methodPhone.addEventListener('change', function() {
                phoneContainer.classList.remove('d-none');
                phoneInput.setAttribute('required', 'required');

                emailContainer.classList.add('d-none');
                emailInput.removeAttribute('required');
                emailInput.value = '';
            });

            actionBtn.addEventListener('click', function(e) {
                if (!otpSent) {

                    if (methodEmail.checked && !emailInput.value) {
                        triggerModal('Please enter your email address.', false);
                        return;
                    }
                    if (methodPhone.checked && !phoneInput.value) {
                        triggerModal('Please enter your phone number.', false);
                        return;
                    }

                    triggerModal('OTP has been successfully sent!', true);

                    otpContainer.classList.remove('d-none');
                    otpInput.setAttribute('required', 'required');

                    methodEmail.disabled = true;
                    methodPhone.disabled = true;
                    emailInput.readOnly = true;
                    phoneInput.readOnly = true;

                    actionBtn.innerText = 'Done';
                    actionBtn.setAttribute('type', 'submit');

                    otpSent = true;
                } else {
                    if (!otpInput.value) {
                        triggerModal('Please enter the received OTP code.', false);
                        e.preventDefault();
                        return;
                    }
                    otpForm.submit();
                }
            });
        });
    </script>
</body>
</html>
