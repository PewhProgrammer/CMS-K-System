<?php
require 'dbconnect.php';
//gets called for every file once
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
/*
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["userfile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats

if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
    && $fileType != "gif"  && $fileType != "pdf"
) {
    echo "Sorry, only JPG, JPEG, PNG, GIF and PDF files are allowed.";
    $uploadOk = 0;
}
*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["userfile"]["name"]) . " has been uploaded.";

        $name = $_FILES["userfile"]["name"];
        $type = "";

        if ($fileType == 'pdf') {
            $type = 'pdf';
        } else {
            $type = 'image';
        }

        $path = $target_dir.$name;

        $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $name . "', '" . $fileType . "', '" . $path . "')");
        $db = $query->getQuery();

    } else {
    echo "Sorry, there was an error uploading your file.";
}
}
?>