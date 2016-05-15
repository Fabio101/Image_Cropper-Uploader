<?php
/**
*
* Author : Fabio Pinto - 50121308
*
* Description : handles the GIT operations required to synchronize the new image with the git repo.
*
**/

class git {
    public function pull() {
        $target_dir = "../client_data/";
        chdir($target_dir);

        exec("git pull", $output, $result);
        
        return $result;
    }
}
?>