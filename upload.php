<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define the target directory to save the uploaded file
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }

    // Get the file info
    $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the uploaded file is a PDF
    if ($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["pdf"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }

    // Redirect to seating arrangement page with the uploaded file name
    header("Location: view_seating.php?file=" . urlencode($target_file));
}
?>
