<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
use App\Repository\CategoryRepository;
use App\Repository\PieceRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name:'admin_')]
class AdminController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function listAll(PieceRepository $pieceRepository, CategoryRepository $categoryRepository): Response
    {
        $piecesBdd = $pieceRepository->findAll();
        $categoriesBdd = $categoryRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'piecesBdd' => $piecesBdd,
            'categoriesBdd' => $categoriesBdd,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function addPiece(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $piece = new Piece();
        $formPiece = $this->createForm(PieceType::class, $piece);
        $formPiece->handleRequest($request);
        if($formPiece->isSubmitted() && $formPiece->isValid()){
            $fileUploaded = $formPiece->get('pcePhoto')->getData();
            if($fileUploaded){
                $fileUploadedName = $fileUploader->upload($fileUploaded);
                $piece->setPcePhoto($fileUploadedName);
            }
            $em->persist($piece);
            $em->flush();
            $this->addFlash('success', 'Votre nouvelle pièce a bien été enregistrée');
            return $this->redirectToRoute('admin_new');
        }

        return $this->render('admin/formPiece.html.twig', [
            'formPiece' => $formPiece->createView(),
        ]);
    }

    #[Route('/update/{slug}', name: 'update')]
    public function updatePiece (EntityManagerInterface $em, Request $request, FileUploader $fileUploader, Piece $piece): Response
    {
        $oldPcePhoto = $piece->getPcePhoto();
        $formUpdate = $this->createForm(PieceType::class, $piece);
        $formUpdate->handleRequest($request);

        if($formUpdate->isSubmitted() && $formUpdate->isValid()){
            $fileUploaded = $formUpdate->get('pcePhoto')->getData();
            //dd($fileUploaded);
            if($fileUploaded){
                $fileUploadedName = $fileUploader->upload($fileUploaded);
                $piece->setPcePhoto($fileUploadedName);
                if ($oldPcePhoto !== null && file_exists('img/'.$oldPcePhoto)) {
                    unlink('img/'.$oldPcePhoto);
                }


            }else {
                $piece->setPcePhoto($oldPcePhoto);
            }

            $em->persist($piece);
            $em->flush();
            $this->addFlash('success', 'Votre pièce a bien été mise à jour');
            return $this->redirectToRoute('admin_update');
        }


        return $this->render('admin/formPiece.html.twig', [
            'formPiece'=> $formUpdate->createView()

        ]);
    }

    #[Route('/delete/{slug}', name: 'delete')]
    public function deletePiece(EntityManagerInterface $em, Piece $piece): Response
    {
        $pcePhoto = $piece->getPcePhoto();
        unlink('img/' . $pcePhoto);
        $em->remove($piece);
        $em->flush();

        $this->addFlash("success", "Votre pièce a été supprimée");
        return $this->redirectToRoute("admin_list");

        return $this->render('admin/formPiece.html.twig');
    }
}
