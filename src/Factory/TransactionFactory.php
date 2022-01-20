<?php

namespace App\Factory;

use App\Entity\Transaction;
use InvalidArgumentException;

abstract class TransactionFactory implements Factory
{

    public static function bootstrap(string $dataJson, Transaction $transaction): mixed
    {
        $data = json_decode($dataJson);

        self::verifyArguments($data);

        $transaction->setDescription($data->description);
        $transaction->setValue(floatval($data->value));

        $date = \DateTime::createFromFormat('d/m/Y', $data->date);
        $transaction->setDate($date);

        return $transaction;
    }

    public static function update(string $dataJson, object $entity): void
    {
        $data = json_decode($dataJson);

        if ($entity instanceof Transaction) {
            if (isset($data->description) === true) {
                $entity->setDescription($data->description);
            }

            if (isset($data->value) === true) {
                $entity->setValue($data->value);
            }

            if (isset($data->date) === true) {
                $date = \DateTime::createFromFormat('d/m/Y', $data->date);
                $entity->setDate($date);
            }
        }
    }

    public static function verifyArguments(\stdClass $transaction)
    {
        if (!isset($transaction->description)) {
            throw new InvalidArgumentException("Undefined argument description");
        }

        if (!isset($transaction->value)) {
            throw new InvalidArgumentException("Undefined argument value");
        }

        if (!isset($transaction->date)) {
            throw new InvalidArgumentException("Undefined argument date");
        }
    }
}