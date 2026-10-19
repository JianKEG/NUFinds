// Show the Bootstrap toast messages (they auto-hide after 4.5 seconds).
document.querySelectorAll('.toast').forEach(function (toast) {
    bootstrap.Toast.getOrCreateInstance(toast).show();
});
