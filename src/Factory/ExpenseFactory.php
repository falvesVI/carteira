<?php

namespace App\Factory;

use App\Entity\Expense;

class ExpenseFactory extends TransactionFactory
{

    public static function make(string $dataJson): mixed
    {
        $expense = new Expense();
        parent::bootstrap($dataJson, $expense);

        return $expense;
    }
}