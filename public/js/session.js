function initializeSessionModal() {
    if (!window.sessionData) return;
    const modalElement = document.getElementById("sessionModal");
    if (!modalElement) return;
    const modalMessage = document.getElementById("modalMessage");
    const modalContent = document.getElementById("sessionModalContent");
    const modal = new bootstrap.Modal(modalElement);
    if (window.sessionData.success) {
        modalMessage.innerText = window.sessionData.success;
        modalContent.classList.remove("border-danger");
        modalContent.classList.add("border-success");
        modal.show();
    }

    if (window.sessionData.error) {
        modalMessage.innerText = window.sessionData.error;
        modalContent.classList.remove("border-success");
        modalContent.classList.add("border-danger");
        modal.show();
    }

}
