<?php

namespace App\Entity;

use App\Repository\CardGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardGameRepository::class)]
class CardGame {}
