<!-- Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3">
            <div class="modal-body">
                <h5 id="modalMessage" style="font-size: 15px;"></h5>
                <button type="button" class="btn custom-btn mt-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-1">
            <div class="modal-header py-2 px-3 border-0">
                <h6 class="modal-title fw-semibold text-dark">Confirmation</h6>
            </div>
            <div class="modal-body text-center pt-1 pb-4 px-3">
                <p id="confirmMessage" class="mb-4 text-secondary" style="font-size: 15px;"></p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn custom-btn" id="confirmOkBtn">OK</button>
                    <button type="button" class="btn custom-btn" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (session('success'))
            document.getElementById("modalMessage").innerText = "{{ session('success') }}";
            document.querySelector("#sessionModal .modal-content").classList.add("border-success");
            var myModal = new bootstrap.Modal(document.getElementById('sessionModal'));
            myModal.show();
        @endif
        @if (session('error'))
            document.getElementById("modalMessage").innerText = "{{ session('error') }}";
            document.querySelector("#sessionModal .modal-content").classList.add("border-danger");
            var myModal = new bootstrap.Modal(document.getElementById('sessionModal'));
            myModal.show();
        @endif
    });

    document.addEventListener("DOMContentLoaded", function() {
        const menuOpen = document.getElementById('menuOpen');
        const menuClose = document.getElementById('menuClose');
        const sidebar = document.getElementById('sidebar');
        const header = document.getElementById('mainHeader');
        const footer = document.getElementById('mainFooter');
        const main = document.querySelector('.main-container');
        if (menuOpen && menuClose && sidebar && header && footer && main) {
            menuOpen.addEventListener('click', () => {
                sidebar.classList.add('collapsed');
                header.classList.add('collapsed');
                footer.classList.add('collapsed');
                main.classList.add('collapsed');
                menuOpen.classList.add('d-none');
                menuClose.classList.remove('d-none');
            });
            menuClose.addEventListener('click', () => {
                sidebar.classList.remove('collapsed');
                header.classList.remove('collapsed');
                footer.classList.remove('collapsed');
                main.classList.remove('collapsed');
                menuClose.classList.add('d-none');
                menuOpen.classList.remove('d-none');
            });
        }
    });

function showError(input, message) {
    let error = input.parentElement.querySelector("small");
    if(error) {
        error.innerText = message;
        error.style.display = "block";
        error.style.marginTop = "5px";
        error.style.color = "#dc3545"; // ரெட் கலர் உறுதி செய்ய
    }
}

function clearError(input) {
    let error = input.parentElement.querySelector("small");
    if(error) {
        error.innerText = "";
    }
}

    document.addEventListener("DOMContentLoaded", function() {
        const forms = document.querySelectorAll(".needs-validation");
        forms.forEach(function(form) {
            form.addEventListener("submit", function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    const firstInvalid = form.querySelector(":invalid");
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }
                }
                form.classList.add("was-validated");
            });
        });
    });


    let messages = {};
    fetch("/json/messages.json")
        .then(response => response.json())
        .then(data => {
            messages = data;
        });

    function showConfirm(message, callback) {
        $('#confirmMessage').text(message);
        let confirmModal = new bootstrap.Modal(
            document.getElementById('confirmModal')
        );
        confirmModal.show();
        $('#confirmOkBtn').off('click').on('click', function() {
            confirmModal.hide();
            callback();
        });
    }
</script>
