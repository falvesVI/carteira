<?php

namespace App\Entity;

use App\Repository\RevenueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RevenueRepository::class)]
class Revenue extends Transaction
{

}
