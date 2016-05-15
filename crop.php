<?php
/**
*
* Author : Fabio Pinto - 50121308
*
* Description : handles the imagemagick class for mage cropping.
*
**/
class cropper {
    // Runs the Imagick class to crop the image with the supplied parameters
    public function edit($outf, $width, $height, $startx, $starty, $file_orig) {
        $image = new Imagick($file_orig);
        $image = $image->coalesceImages();
        $image->cropImage($width, $height, $startx, $starty);
        $image->writeImage($outf);
    }
}
?>