<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name:'admin_')]
class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie')]
    public function addCategory(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted() && $formCategory->isValid()){
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'La nouvelle catégorie a bien été enregistrée');
            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('category/formCategory.html.twig', [
            'formCategory' => $formCategory->createView(),
        ]);
    }
}
