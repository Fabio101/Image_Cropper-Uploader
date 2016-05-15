<?php
/**
*
* Author : Fabio Pinto - 50121308
*
* Description : handles the file upload and resize operations for the image cropper app.
*
**/
require_once("git.php");

$target_dir = "../client_data/". $_POST["company_login"] . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//Ensure Git repo is up to date...
$GIT = new git();
if ($GIT->pull() !=0) {
    $uploadOk= 0;
    echo "PHP was unable to succesfully run the git command! Contact support@parallel.co.za!";
    header("HTTP/1.1 500 PHP was unable to succesfully run the git command! Contact support@parallel.co.za! ");
}

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
    echo "Company Login name does not exist. Please try again.";
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
    
// if everything is ok, try to upload, resize and replace the file...
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
        // Get new sizes
        list($width, $height) = getimagesize($target_file);
        $newx = $_POST["x"];
        $newy = $_POST["y"];
        $newwidth = $_POST["width"];
        $newheight = $_POST["height"] ;
        
        //Begin resize operation and replacements...
        resizeImage($newx, $newy, $newwidth, $newheight, $width, $height, $target_dir, $target_file);
    
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header("HTTP/1.1 200 OK");
    } else {
        echo "Sorry, there was an error uploading your file, Please contact support@parallel.co.za.";
        header("HTTP/1.1 500 An error occured whilst trying upload your image!");
    }
}

function resizeImage($x, $y, $neww, $newh, $w, $h, $dir, $file) {
    
    // Recheck extention for below conditional
    $ext2 = end((explode(".", $file)));
    
    if ($ext2 == "jpg") {
        // We use Imagick to crop the file and write to a new jpg
        $outFile = $dir . "cropped.png";
        $image = new Imagick($file);
        $image->cropImage($h, $w, $x, $y);
        $image->writeImage($outFile);
        
    } else {
        // We use Imagick to crop the file and write to a new png
        $outFile = $dir . "cropped.png";
        $image = new Imagick($file);
        $image->cropImage($h, $w, $x, $y);
        $image->writeImage($outFile);
    }
    replace($dir, $ext2, $file, $outFile);
}

function replace($d, $e, $f, $of) {
    // Now we replace the old image with the new one
    unlink($d. "company." . $e);
    unlink($f);
    rename($of, $d . "company." . $e);
}
?>