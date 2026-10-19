// Post Item form: Lost/Found toggle + required student fields (Lost only) + photo preview
const typeToggle = document.getElementById('type-toggle');
const postForm = document.getElementById('post-form');

if (typeToggle) {
    const radios = typeToggle.querySelectorAll('input[name="item_type"]');
    const studentSection = document.getElementById('student-section');
    const studentDivider = document.getElementById('student-divider');
    const studentFields = ['student_name', 'student_id', 'email'].map(function (id) {
        return document.getElementById(id);
    });
    const locationLabel = document.getElementById('location-label');
    const dateLabel = document.getElementById('date-label');

    function updateType() {
        const isLost = typeToggle.querySelector('input:checked').value === 'Lost';

        // student name, ID, and email are required only for Lost reports
        studentSection.hidden = !isLost;
        studentDivider.hidden = !isLost;
        studentFields.forEach(function (field) {
            field.required = isLost;
        });

        // section numbers shift when the student section is shown
        document.getElementById('item-info-number').textContent = isLost ? '03' : '02';
        document.getElementById('photo-info-number').textContent = isLost ? '04' : '03';

        locationLabel.firstChild.nodeValue = isLost ? 'Last seen at ' : 'Location found ';
        dateLabel.firstChild.nodeValue = isLost ? 'Date lost ' : 'Date found ';
    }

    radios.forEach(function (radio) {
        radio.addEventListener('change', updateType);
    });
    updateType();
    postForm.addEventListener('reset', function () {
        window.setTimeout(updateType, 0);
    });
}

// Photo preview before upload (Lost and Found staff only)
const imageInput = document.getElementById('imageInput');

if (imageInput) {
    const preview = document.getElementById('imagePreview');
    const uploadTitle = document.getElementById('upload-title');
    const photoError = document.getElementById('photo-error');
    const defaultText = 'PNG, JPG or WEBP, up to 2 MB';

    imageInput.addEventListener('change', function () {
        const file = imageInput.files[0];
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        let error = '';

        if (file && allowed.indexOf(file.type) === -1) {
            error = 'Only JPG, PNG, or WEBP images are allowed.';
        } else if (file && file.size > 2 * 1024 * 1024) {
            error = 'That photo is larger than 2 MB. Please choose a smaller one.';
        }

        photoError.textContent = error;
        photoError.hidden = error === '';

        if (!file || error !== '') {
            imageInput.value = '';
            preview.hidden = true;
            uploadTitle.textContent = defaultText;
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.hidden = false;
        uploadTitle.textContent = 'Photo ready to upload';
    });

    postForm.addEventListener('reset', function () {
        window.setTimeout(function () {
            preview.hidden = true;
            preview.removeAttribute('src');
            photoError.textContent = '';
            photoError.hidden = true;
            uploadTitle.textContent = defaultText;
        }, 0);
    });
}
