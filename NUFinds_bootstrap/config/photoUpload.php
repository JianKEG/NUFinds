<?php
// Checks the photo (type + size) and saves it to assets/uploads/. Returns the file name, or false on error.
function uploadPhoto($file) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "The photo could not be uploaded. Please try again.";
        return false;
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        $_SESSION['error'] = "The photo is too large. Maximum size is 2 MB.";
        return false;
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed) || getimagesize($file['tmp_name']) === false) {
        $_SESSION['error'] = "Only JPG, PNG, or WEBP images are allowed.";
        return false;
    }

    $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    move_uploaded_file($file['tmp_name'], __DIR__ . '/../assets/uploads/' . $fileName);

    return $fileName;
}
?>
