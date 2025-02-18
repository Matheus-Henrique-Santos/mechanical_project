<?php

namespace App\Traits;

trait GenerateTags
{
    public function generateReference($id)
    {
        $month = (int)date("m");
        $year = date("y");

        $yearSumLastTwoDigits = (int) substr($year, 1) + (int) substr($year, -1) ;
        $reference = $year.str_pad( (($yearSumLastTwoDigits+$month) * $id),10,0,STR_PAD_LEFT);

        return $reference;
    }
}
