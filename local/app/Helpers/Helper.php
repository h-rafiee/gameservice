<?php

namespace App\Helpers;

class Helper {

    public function generateNumber($length = 10){
        return substr(str_shuffle(str_repeat("0123456789",(int) $length/5)), 0, $length);
    }

    public function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function fixEmail($email){
        $spliter = explode("@",$email);
        $part_1 = str_replace(".","",$spliter[0]);
        $spliter[0] = $part_1;
        $fixed_email = implode("@",$spliter);
        return $fixed_email;
    }

}