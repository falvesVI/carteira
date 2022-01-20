<?php

namespace App\Controller;


use App\Factory\RevenueFactory;
use App\Repository\RevenueRepository;
use Doctrine\ORM\EntityManagerInterface;


class RevenueController extends TransactionController
{
    public function __construct(RevenueFactory $factory, RevenueRepository $repository, EntityManagerInterface $doctrine)
    {
        parent::__construct($doctrine);
        $this->factory = $factory;
        $this->repository = $repository;
    }

}

