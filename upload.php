<?php
$target_dir = "../client_data/". $_POST["company_login"] . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
        header("HTTP/1.1 500 Not an image! ");
    }
}

// Check is target dirctory exists
if (!file_exists ( $target_dir )) {
    echo "Company Login name does not exist.";
    $uploadOk = 0;
    header("HTTP/1.1 500 Not a valid Company login name! ");
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large. ";
    $uploadOk = 0;
    header("HTTP/1.1 500 Image is too large!");
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
    $uploadOk = 0;
    header("HTTP/1.1 500 Not a valid image format!");
}else {
    // Determine file extension
    $ext = end((explode(".", $target_file)));
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    header("HTTP/1.1 500 An error occured whilst trying upload your image! ");
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        unlink($target_dir. "company." . $ext);
        rename($target_file, $target_dir . "company." . $ext);
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header("HTTP/1.1 200 OK");
    } else {
        echo "Sorry, there was an error uploading your file, Please contact support@parallel.co.za.";
        header("HTTP/1.1 500 An error occured whilst trying upload your image!");
    }
}
?>