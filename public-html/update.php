<?php
 if(isset($_POST["insert"]))
 {
   // get the data from the JS Ajax call on which port to trigger
   $myData = json_decode($_POST["insert"], true);

   // $myData['num'] is the DIO port number (1-4)
   if ((is_numeric($myData['num'])) && (is_numeric($myData['status'])))
   { 
     $exec = "echo out > /dev/dio-{$myData['num']}";
     shell_exec($exec);

     $exec = "echo {$myData['status']} > /dev/dio-{$myData['num']}";
     shell_exec($exec);
   }
 }
?>
  