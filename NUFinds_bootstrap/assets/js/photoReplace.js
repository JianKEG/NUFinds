// Add / replace a photo from the table. Submits automatically once a valid image is chosen.
document.querySelectorAll('.photo-form').forEach(function (form) {
    const fileInput = form.querySelector('input[type="file"]');
    const button = form.querySelector('.js-replace-photo');

    button.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if (!file) {
            return;
        }

        if (allowed.indexOf(file.type) === -1) {
            alert('Only JPG, PNG, or WEBP images are allowed.');
            fileInput.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('That photo is larger than 2 MB. Please choose a smaller one.');
            fileInput.value = '';
            return;
        }

        form.submit();
    });
});
