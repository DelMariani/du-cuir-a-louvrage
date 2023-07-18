<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\PieceRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function listOfAll(Request $request, PieceRepository $pieceRepository, CategoryRepository $categoryRepository, TrainingRepository $trainingRepository, MailerInterface $mailer): Response
    {
        $piecesBdd = $pieceRepository->findAll();
        $categoriesBdd = $categoryRepository->findAll();
        $trainingsBdd = $trainingRepository->findAll();

        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('admin@admin.com')
                ->subject('Demande de contact')
                ->text($data['prenom'] . PHP_EOL . $data['nom'] . PHP_EOL . $data['email'] . PHP_EOL . $data['telephone'] . PHP_EOL . $data['content']);

            $mailer->send($email);
        }

        return $this->render('main/home.html.twig', [
            'piecesBdd' => $piecesBdd,
            'categoriesBdd' => $categoriesBdd,
            'trainingsBdd' => $trainingsBdd,
            'contactForm' => $contactForm->createView(),
        ]);
    }

    #[Route('/details/{slug}', name: 'details')]
    public function details(string $slug, PieceRepository $pieceRepository): Response
    {
        $piece = $pieceRepository->findOneBy(['slug' => $slug]);

        return $this->render('main/details.html.twig', [
            'piece' => $piece,
        ]);
    }
}
