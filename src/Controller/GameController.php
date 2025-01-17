<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/game', name: 'app_game')]
final class GameController extends AbstractController
{
    private GameRepository $gameRepository;
    private EntityManagerInterface $em;

    public function __construct(GameRepository $gameRepository, EntityManagerInterface $em)
    {
        $this->gameRepository = $gameRepository;
        $this->em = $em;
    }

    #[Route('/', name: '_index')]
    public function index(): Response
    {
        $games = $this->gameRepository->findAll();


        return $this->render('game/index.html.twig', [
            'games' => $games
        ]);
    }

    #[Route('/{id}', name: '_show')]
    public function show(int $id): Response
    {
        $game = $this->gameRepository->find($id);

        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }
}
