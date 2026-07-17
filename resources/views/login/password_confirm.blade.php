<!DOCTYPE html>
<html lang="en">
@include('layout.include.head')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row align-items-stretch bg-white border rounded shadow w-100 overflow-hidden login-card-row">

            <div class="col-md-6 p-0 d-none d-md-block position-relative">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80"
                     alt="Reset Password Illustration"
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            </div>

            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="reset-form">
                    <h2 class="text-center mb-4 fw-bold">Reset Password</h2>

                    <form method="POST" action="" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="token">

                        <div class="input-group-custom form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" required readonly placeholder="Email Address">
                            <label for="email">Email Address</label>
                            <i class="bi bi-envelope-fill input-icon-end text-muted"></i>
                        </div>

                        <div class="input-group-custom form-floating mb-3">
                            <input type="password" class="form-control password-input" id="password" name="password" required placeholder="New Password">
                            <label for="password">New Password</label>
                            <i class="bi bi-eye-slash-fill input-icon-end toggle-password"></i>
                            <small class="text-danger"></small>
                        </div>

                        

                        <button type="submit" class="btn btn-custom-primary w-100">Update Password</button>
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
