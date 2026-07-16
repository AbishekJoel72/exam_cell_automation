<!DOCTYPE html>
<html lang="en">
@include('layout.include.head')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row align-items-stretch bg-white border rounded shadow w-100 overflow-hidden login-card-row">

            <div class="col-md-6 p-0 d-none d-md-block position-relative">
                <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?auto=format&fit=crop&w=600&q=80"
                     alt="Exam Cell"
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            </div>

            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="login-form">
                    <h2 class="text-center mb-4 fw-bold">Login</h2>
                    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="login_type" value="true">

                        <div class="input-group-custom form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Email / Registration No">
                            <label for="username">Email / Registration No</label>
                            <i class="bi bi-person-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>

                        <div class="input-group-custom form-floating mb-3">
                            <input type="password" class="form-control password-input" id="password" name="password" required placeholder="Password">
                            <label for="password">Password</label>
                            <i class="bi bi-eye-slash-fill input-icon-end toggle-password"></i>
                            <small class="text-danger"></small>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember" style="font-size: 0.9rem;">Remember me</label>
                            </div>
                            <a href="{{ route('password_request') }}" class="forgot-link text-decoration-none" style="font-size: 0.9rem;">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-custom-primary w-100">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @include('layout.include.script')

    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.password-input');
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-slash-fill');
                    this.classList.add('bi-eye-fill');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye-fill');
                    this.classList.add('bi-eye-slash-fill');
                }
            });
        });
    </script>
</body>
</html>
