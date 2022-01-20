<?php

namespace App\Controller;


use App\Factory\ExpenseFactory;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;


class ExpenseController extends TransactionController
{
    public function __construct(ExpenseFactory $factory, ExpenseRepository $repository, EntityManagerInterface $doctrine)
    {
        parent::__construct($doctrine);
        $this->factory = $factory;
        $this->repository = $repository;
    }

}
