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
        // Return exec exit code 
        return $result;
    }
    
    // A git add to ensure that any new files that need to be commited are tracked
    public function add($dir) {
        chdir($dir);
        exec("git add .", $output, $result);
        // Return exec exit code
        return $result;
    }
    
    // A git commit command with commit message
    public function commit($dir, $company) {
        chdir($dir);
        exec("git commit -m 'Logo Cropper Commit for '" . $company, $output, $result);
        // Return exec exit code
        return $result;
    }
}
?>