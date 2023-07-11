<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formation', name : 'admin_training')]
class TrainingController extends AbstractController
{
    #[Route('/new', name: '_new')]
    public function addTraining(Request $request, EntityManagerInterface $em): Response
    {
        $training = new Training();
        $formTraining = $this->createForm(TrainingType::class, $training);
        $formTraining->handleRequest($request);
        if($formTraining->isSubmitted() && $formTraining->isValid()){
        $em->persist($training);
        $em->flush();
        $this->addFlash('success', "Votre nouvelle formation a bien été enregistrée");
        return $this->redirectToRoute('admin_list');
    }
    return $this->render('training/formTraining.html.twig', [
        'formTraining'=> $formTraining->createView(),
]);

    }

    #[Route('/update/{slug}', name: '_update')]
    public function updateTraining (EntityManagerInterface $em, Request $request, Training $training): Response
    {
        $formUpdate = $this->createForm(TrainingType::class, $training);
        $formUpdate->handleRequest($request);
        if($formUpdate->isSubmitted() && $formUpdate->isValid()){
            $em->persist($training);
            $em->flush();
            $this->addFlash('success', 'Votre formation a bien été mise à jour');
            return $this->redirectToRoute('admin_list');
        }

        return $this->render('training/formTraining.html.twig', [
            'formTraining'=> $formUpdate->createView()
        ]);
    }

    #[Route('/delete/{slug}', name: '_delete')]
    public function deleteTraining(EntityManagerInterface $em, Training $training): Response
    {
        $em->remove($training);
        $em->flush();

        $this->addFlash("success", "Votre formation a été supprimée");
        return $this->redirectToRoute("admin_list");

        return $this->render('training/formTraining.html.twig');
    }
}
