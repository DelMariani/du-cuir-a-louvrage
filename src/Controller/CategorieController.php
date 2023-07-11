<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categorie', name:'admin_category')]
class CategorieController extends AbstractController
{
    #[Route('/new', name: '_new')]
    public function addCategory(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted() && $formCategory->isValid()){
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'La nouvelle catégorie a bien été enregistrée');
            return $this->redirectToRoute('admin_list');
        }
        return $this->render('category/formCategory.html.twig', [
            'formCategory' => $formCategory->createView(),
        ]);
    }

    #[Route('/update/{id}', name: '_update', requirements: ['id' => '\d+'])]
    public function updateCategory (EntityManagerInterface $em, Request $request, Category $category): Response
    {
        $formUpdate = $this->createForm(CategoryType::class, $category);
        $formUpdate->handleRequest($request);
        if($formUpdate->isSubmitted() && $formUpdate->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Votre catégorie a bien été mise à jour');
            return $this->redirectToRoute('admin_list');
        }
        return $this->render('category/formCategory.html.twig', [
            'formCategory'=> $formUpdate->createView()

        ]);
    }

    #[Route('/delete/{id}', name: '_delete', requirements: ['id' => '\d+'])]
    public function deleteCategory(EntityManagerInterface $em, Category $category): Response
    {
        $pieces = $category->getPieces();
        foreach ($pieces as $piece){
           $em->remove($piece);
        }
        $em->remove($category);
        $em->flush();

        $this->addFlash("success", "Votre catégorie et ses pièces associées ont été supprimées");
        return $this->redirectToRoute("admin_list");

        return $this->render('category/formCategory.html.twig');
    }
}
