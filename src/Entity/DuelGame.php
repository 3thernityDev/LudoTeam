<?php

namespace App\Entity;

use App\Repository\DuelGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DuelGameRepository::class)]
class DuelGame {}
