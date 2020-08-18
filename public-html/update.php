<?php
 if(isset($_POST["insert"]))
 {
   $myData = json_decode($_POST["insert"], true);

   $exec = "echo out > /dev/dio-{$myData['num']}";
   shell_exec($exec);

   $exec = "echo {$myData['status']} > /dev/dio-{$myData['num']}";
   shell_exec($exec);
 }
?>
  