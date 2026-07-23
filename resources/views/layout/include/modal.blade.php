<!-- Session Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3" id="sessionModalContent">
            <div class="modal-body">
                <h5 id="modalMessage" style="font-size: 15px;"></h5>
                <button type="button" class="btn custom-btn mt-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- confirmModal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-1">
            <div class="modal-header py-2 px-3 border-0">
                <h6 class="modal-title fw-semibold text-dark">Confirmation</h6>
            </div>
            <div class="modal-body text-center pt-1 pb-4 px-3">
                <p id="confirmMessage"class="mb-4 text-secondary"></p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn custom-btn" id="confirmOkBtn"> OK </button>
                    <button type="button" class="btn custom-btn" data-bs-dismiss="modal"> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
