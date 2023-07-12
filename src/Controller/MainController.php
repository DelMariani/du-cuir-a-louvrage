<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PieceRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function listOfAll(PieceRepository $pieceRepository, CategoryRepository $categoryRepository, TrainingRepository $trainingRepository): Response
    {
        $piecesBdd = $pieceRepository->findAll();
        $categoriesBdd = $categoryRepository->findAll();
        $trainingsBdd = $trainingRepository->findAll();

        return $this->render('main/home.html.twig', [
            'piecesBdd' => $piecesBdd,
            'categoriesBdd' => $categoriesBdd,
            'trainingsBdd' => $trainingsBdd,
        ]);
    }
    #[Route('/details/{slug}', name: 'details')]
    public function details(string $slug,PieceRepository $pieceRepository): Response
    {
        $piece = $pieceRepository->findOneBy(['slug'=> $slug]);

        return $this->render('main/details.html.twig', [
            'piece' => $piece,
        ]);
    }
}
