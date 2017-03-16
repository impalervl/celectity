<?php

namespace App\MyCustom;

use Illuminate\Support\Facades\DB;
class Trans
{
    public function parsed($string){

        $results = explode(" ",$string);

        foreach($results as $result){
            if($result == 'B'){
                return 4;
            }
            if($result == 'C'){
                return 7.5;
            }
            if($result == 'D'){
                return 4;
            }
        }
        return 1;
    }
}