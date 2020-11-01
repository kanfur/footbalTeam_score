<?php

namespace App\Helpers;

class Functions{

    public function search_for_id($id, $array,$weekly_matches_ids) {
        foreach ($array as $key => $val) {

            if ($id == $val["home"]) {
                if(count($weekly_matches_ids)>0){
                    if(array_search($val["away"],$weekly_matches_ids)===false){
                        return $key;
                    }
                }else{
                    return $key;
                }
            }
            if($id == $val["away"]){
                if(count($weekly_matches_ids)>0){
                    if(array_search($val["home"],$weekly_matches_ids)===false){
                        return $key;
                    }
                }else{
                    return $key;
                }
            }
        }

        return null;
    }
    public function getMaxNumberByRandom($tries,$limit){
        //gol atan takım en yüksek sayıyı elde etmeye çalışacak
        //gol yiyen taraf en çok golü kurtarmaya çalışacak

        $minumum = null;

        for($i=0; $i < $tries ; $i++){
            $random  = rand(0, $limit);
            if($minumum){
                $minumum = $minumum < $random?$random : $minumum;
            }else{
                $minumum = $random;
            }
        }

        return $minumum;
    }
}


