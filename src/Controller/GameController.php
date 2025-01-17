<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\BoardGame;
use App\Entity\CardGame;
use App\Entity\DuelGame;
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

    ########
    #INDEX#
    ########

    #[Route('/', name: '_index')]
    public function index(): Response
    {
        $games = $this->gameRepository->findAll();

        return $this->render('game/index.html.twig', [
            'games' => $games
        ]);
    }

    ########
    #SHOW#
    ########

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
        $game = new Game();  // Commencer par une entité Game générique

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le type de jeu depuis le formulaire
            $type = $form->get('type')->getData();

            // Créer la bonne sous-classe selon le type sélectionné
            switch ($type) {
                case 'board_game':
                    $game = new BoardGame();
                    break;
                case 'card_game':
                    $game = new CardGame();
                    break;
                case 'duel_game':
                    $game = new DuelGame();
                    break;
                default:
                    throw new \Exception('Type de jeu inconnu');
            }

            // Remplir les autres champs (nom, description, etc.)
            $game->setName($form->get('name')->getData());
            $game->setDescription($form->get('description')->getData());

            // Persist et flush l'entité
            $this->em->persist($game);
            $this->em->flush();

            // Redirection vers la page de détails du jeu créé
            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }

        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    ########
    #UPDATE#
    ########

    #[Route('/update/{id}', name: '_update')]
    public function edit(Request $request, int $id): Response
    {
        $game = $this->gameRepository->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Jeu non trouvé !');
        }

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('app_game_index');
        }

        return $this->render('game/update.html.twig', [
            'form' => $form->createView(),
            'game' => $game,
        ]);
    }

    ########
    #DELETE#
    ########

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(int $id): Response
    {
        $game = $this->gameRepository->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Jeu non trouvé !');
        }

        $this->em->remove($game);
        $this->em->flush();

        return $this->redirectToRoute('app_game_index');
    }
}
