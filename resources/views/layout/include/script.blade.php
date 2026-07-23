<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: 'Success',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK',
        confirmButtonColor: '#0d6efd',
        allowOutsideClick: false,
        width: '350px',
        customClass: {
            title: 'session-title'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: 'Error',
        text: "{{ session('error') }}",
        confirmButtonText: 'OK',
        confirmButtonColor: '#0d6efd',
        allowOutsideClick: false,
        width: '350px',
        customClass: {
            title: 'session-title'
        }
    });
});
</script>
@endif


<script src="{{ asset('js/validation.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
