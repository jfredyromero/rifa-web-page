$(document).ready(function () {
    let myModalEl = document.querySelector('#card-popup');
    let modal = bootstrap.Modal.getOrCreateInstance(myModalEl); // Returns a Bootstrap modal instance
    modal.show();
});