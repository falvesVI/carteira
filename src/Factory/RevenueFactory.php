<?php

namespace App\Factory;

use App\Entity\Revenue;

class RevenueFactory extends TransactionFactory
{

    public static function make(string $dataJson): mixed
    {
        $revenue = new Revenue();
        parent::bootstrap($dataJson, $revenue);

        return $revenue;
    }
}