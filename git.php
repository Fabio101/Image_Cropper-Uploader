<?php
/**
*
* Author : Fabio Pinto - 50121308
*
* Description : handles the GIT operations required to synchronize the new image with the git repo.
*
**/

class git {
    // A git pull to pull down any chanegs to the repo locally that may have occured since the last time this application has run.
    public function pull($dir) {
        chdir($dir);
        exec("git pull", $output, $result);
        // Return exc exitcode 
        return $result;
    }
}
?>