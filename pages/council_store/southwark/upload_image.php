<?php
define("UPLOAD_DIR", "uploads_image/");
// show upload form
if ($_SERVER["REQUEST_METHOD"] == "GET") {
?>

<?php
}
// process file upload
else if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }
    // verify the file type
    $fileType = exif_imagetype($_FILES["myFile"]["tmp_name"]);
    $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    if (!in_array($fileType, $allowed)) {
        echo "<p>File type is not permitted.</p>";
        exit;
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($name);
    while (file_exists(UPLOAD_DIR . $name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }
    // preserve file from temporary directory
    $success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
    if (!$success) {
        echo "<p>Unable to save file.</p>";
        exit;
    }
    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);
    echo "<p>Thank you for your upload. It will now be verified by admin before it's available on the site!";
}

