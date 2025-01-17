<?php

namespace App\Entity;

use App\Repository\BoardGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardGameRepository::class)]
class BoardGame {}
