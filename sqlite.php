<?php
/**
*
* Author : Fabio Pinto - 50121308
*
* Description : handles the connection to the local SQLITE3 database.
*
**/

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('credentials');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "OK";
   }
?>
