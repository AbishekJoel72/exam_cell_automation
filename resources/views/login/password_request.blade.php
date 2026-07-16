<!DOCTYPE html>
<html lang="en">
@include('layout.include.head')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row align-items-stretch bg-white border rounded shadow w-100 overflow-hidden login-card-row">

            <div class="col-md-6 p-0 d-none d-md-block position-relative">
                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80"
                     alt="Forgot Password Illustration"
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            </div>

            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="forgot-form">
                    <h2 class="text-center mb-3 fw-bold">Forgot Password</h2>
                    <p class="text-muted text-center small mb-4">
                        Enter your email address and we will send you a link to reset your password.
                    </p>

                    <form method="POST" action="{{ route('password_request') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="input-group-custom form-floating mb-4">
                            <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com">
                            <label for="email">Email Address</label>
                            <i class="bi bi-envelope-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>

                        <button type="submit" class="btn btn-custom-primary w-100 mb-3">Send Reset Link</button>

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
</body>
</html>
