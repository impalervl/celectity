<?php

 function parse($string){
     $results = explode(" ",$string);

     foreach($results as $result){
         if($result == 'B'){
             return 4;
         }
         else if($result == 'C'){
             return 7.5;
         }
         else if($result == 'D'){
             return 4;
         }
     }
     return 1;
 }