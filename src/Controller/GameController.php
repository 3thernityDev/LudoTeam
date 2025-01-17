<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/show/{id}', name: '_show')]
    public function show(int $id): Response
    {
        $game = $this->gameRepository->find($id);

        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }

    ########
    #CREATE#
    ########

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $game = new Game();

        $form = $this->createForm(GameFormType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($game);
            $this->em->flush();

            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }

        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
