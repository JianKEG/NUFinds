// Found Items: fill the Bootstrap "Mark as claimed" modal with the item that was clicked.
const claimModal = document.getElementById('claim-modal');

claimModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('claim-id').value = button.dataset.id;
    document.getElementById('claim-name').textContent = button.dataset.name;
});
