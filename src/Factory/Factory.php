<?php

namespace App\Factory;

interface Factory
{
    public static function make(string $dataJson): mixed;

    public static function update(string $dataJson, object $entity): void;
}