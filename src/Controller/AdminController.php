<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Piece;
use App\Form\PieceType;
use App\Repository\CategoryRepository;
use App\Repository\PieceRepository;
use App\Repository\TrainingRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin', name:'admin_')]
class AdminController extends AbstractController
{
    // READ
    #[Route('/list', name: 'list')]
    public function listAll(PieceRepository $pieceRepository, CategoryRepository $categoryRepository, TrainingRepository $trainingRepository): Response
    {
        $piecesBdd = $pieceRepository->findAll();
        $categoriesBdd = $categoryRepository->findAll();
        $trainingsBdd = $trainingRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'piecesBdd' => $piecesBdd,
            'categoriesBdd' => $categoriesBdd,
            'trainingsBdd' => $trainingsBdd
        ]);
    }

    //CREATE
    #[Route('/new', name: 'new')]
    public function addPiece(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $piece = new Piece();
        $formPiece = $this->createForm(PieceType::class, $piece);
        $formPiece->handleRequest($request);
        if ($formPiece->isSubmitted() && $formPiece->isValid()) {
            $fileUploaded = $formPiece->get('images')->getData();
            if ($fileUploaded) {
                foreach ($fileUploaded as $file) {
                    $fileUploadedName = $fileUploader->upload($file);

                    $img = new Images();
                    $img->setName($fileUploadedName);
                    $piece->addImage($img);
                }

            }
            $em->persist($piece);
            $em->flush();
            $this->addFlash('success', 'Votre nouvelle pièce a bien été enregistrée');
            return $this->redirectToRoute('admin_list');
        }

        return $this->render('admin/formPiece.html.twig', [
            'formPiece' => $formPiece->createView(),
        ]);
    }

    //UPDATE
    #[Route('/update/{slug}', name: 'update')]
    public function updatePiece(EntityManagerInterface $em, Request $request, FileUploader $fileUploader, Piece $piece, SluggerInterface $slugger): Response
    {
        $oldSlug = $piece->getSlug();
        $oldImages = $piece->getImages()->toArray(); // Convertir la collection en tableau

        $formUpdate = $this->createForm(PieceType::class, $piece);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {
            $fileUploaded = $formUpdate->get('images')->getData();

            // Supprimer les anciennes images
            foreach ($oldImages as $oldImage) {
                $imageName = $oldImage->getName();
                unlink('img/' . $imageName);
                $piece->removeImage($oldImage);
                $em->remove($oldImage);
            }

            if ($fileUploaded) {
                foreach ($fileUploaded as $file) {
                    $fileUploadedName = $fileUploader->upload($file);

                    $img = new Images();
                    $img->setName($fileUploadedName);
                    $piece->addImage($img);
                }
            }

            $piece->computeSlug($slugger);

            $em->persist($piece);
            $em->flush();

            $this->addFlash('success', 'Votre pièce a bien été mise à jour');
            return $this->redirectToRoute('admin_list');
        }

        return $this->render('admin/formPiece.html.twig', [
            'formPiece' => $formUpdate->createView()
        ]);
    }


    // DELETE
    #[Route('/delete/{slug}', name: 'delete')]
    public function deletePiece(EntityManagerInterface $em, Piece $piece): Response
    {
        $images = $piece->getImages();

        foreach ($images as $image) {
            $imagePath = 'img/' . $image->getName();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $em->remove($piece);
        $em->flush();

        $this->addFlash("success", "Votre pièce a été supprimée");
        return $this->redirectToRoute("admin_list");
    }


}