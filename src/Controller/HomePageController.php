<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    #[Route('/home/page', name: 'app_home_page')]
    public function index(EventRepository $eventRepository, GameRepository $gameRepository): Response
    {
        $events = $eventRepository->findBy([], ['date' => 'DESC'], 5);
        $games = $gameRepository->findBy([], [], 5); 

        return $this->render('home_page/index.html.twig', [
            'events' => $events,
            'games' => $games,
        ]);
    }
}
