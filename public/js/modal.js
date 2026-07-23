let messages = {};

fetch("/json/messages.json")
    .then(response => response.json())
    .then(data => {
        messages = data;
    })
    .catch(error => {
        console.error("Unable to load messages.json", error);
    });

function showConfirm(message, callback) {
    document.getElementById("confirmMessage").innerText = message;
    const modalElement = document.getElementById("confirmModal");
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    document.getElementById("confirmOkBtn").onclick = function () {
        modal.hide();
        if (typeof callback === "function") {
            callback();
        }
    };
}
